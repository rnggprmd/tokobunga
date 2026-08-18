<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Pembayaran;
use App\Models\Invoice;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Transaction;

class CheckoutController extends Controller
{
    public function __construct()
    {
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');
    }

    public function index()
    {
        $cart = session()->get('cart', []);
        if(empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Keranjang Anda kosong.');
        }

        $total = 0;
        foreach($cart as $item) {
            $total += $item['harga'] * $item['quantity'];
        }

        $categories = \App\Models\Category::all();
        return view('checkout.index', compact('cart', 'total', 'categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:15',
            'customer_email' => 'required|email|max:255',
            'alamat_pengiriman' => 'required|string',
        ]);

        $cart = session()->get('cart', []);
        if(empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Keranjang Anda kosong.');
        }

        // SEK-04: Validate stock availability before creating order
        $productIds = array_keys($cart);
        $products   = Product::whereIn('id', $productIds)->get()->keyBy('id');

        foreach ($cart as $productId => $item) {
            $product = $products->get($productId);

            if (!$product) {
                return back()->with('error', "Produk '{$item['nama']}' sudah tidak tersedia. Silakan hapus dari keranjang.");
            }

            if ($product->stok < $item['quantity']) {
                return back()->with('error', "Stok '{$product->nama_produk}' tidak mencukupi. Stok tersedia: {$product->stok}.");
            }
        }

        $total = 0;
        foreach($cart as $item) {
            $total += $item['harga'] * $item['quantity'];
        }

        DB::beginTransaction();
        try {
            // Create Order
            $order = Order::create([
                'user_id' => Auth::id(),
                'total_harga' => $total,
                'status' => 'pending',
                'metode_pembayaran' => 'midtrans',
                'alamat_pengiriman' => $request->alamat_pengiriman,
                'customer_name' => $request->customer_name,
                'customer_email' => $request->customer_email,
                'customer_phone' => $request->customer_phone,
            ]);

            // Save Items
            foreach($cart as $id => $item) {
                \App\Models\OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $id,
                    'jumlah' => $item['quantity'],
                    'harga_satuan' => $item['harga'],
                    'subtotal' => $item['harga'] * $item['quantity'],
                    'harga' => $item['harga'] * $item['quantity'],
                ]);
            }

            // Create initial Pembayaran log
            Pembayaran::create([
                'order_id' => $order->id,
                'metode_pembayaran' => 'midtrans',
                'jumlah_bayar' => $total,
                'status_pembayaran' => 'pending',
            ]);

            DB::commit();

            // Clear Cart
            session()->forget('cart');

            return redirect()->route('checkout.payment', $order->id);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan saat memproses pesanan.');
        }
    }

    public function payment(Order $order)
    {
        if ($order->user_id && $order->user_id !== Auth::id()) {
            abort(403);
        }

        if ($order->status !== 'pending') {
            return redirect()->route('home')->with('info', 'Pesanan ini sudah diproses.');
        }

        $params = array(
            'transaction_details' => array(
                // Append timestamp to avoid duplicate order ID if midtrans is re-triggered
                'order_id' => $order->id . '-' . time(),
                'gross_amount' => $order->total_harga,
            ),
            'customer_details' => array(
                'first_name' => $order->customer_name,
                'email' => $order->customer_email,
                'phone' => $order->customer_phone,
            ),
        );

        try {
            $snapToken = Snap::getSnapToken($params);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Midtrans Snap Token Error: ' . $e->getMessage());
            return redirect()->route('cart.index')->with('error', 'Gagal menghubungkan ke gateway pembayaran Midtrans. Silakan coba beberapa saat lagi.');
        }

        $categories = \App\Models\Category::all();

        return view('checkout.payment', compact('order', 'snapToken', 'categories'));
    }

    public function callback(Request $request)
    {
        $serverKey = config('midtrans.server_key');
        $hashed = hash("sha512", $request->order_id.$request->status_code.$request->gross_amount.$serverKey);
        
        if($hashed == $request->signature_key){
            $real_order_id = explode('-', $request->order_id)[0];
            $order = Order::find($real_order_id);
            if($order){
                $this->processPaymentStatus($order, $request->transaction_status);
            }
        }
        return response()->json(['message' => 'ok']);
    }

    public function sync(Request $request)
    {
        // This is a secure fallback where the frontend passes the midtrans transaction_id
        // We query Midtrans API Server directly to prevent manipulation
        try {
            $transaction_id = $request->transaction_id;
            $status_response = Transaction::status($transaction_id);
            
            $real_order_id = explode('-', $status_response->order_id)[0];
            $order = Order::find($real_order_id);
            
            if($order){
                $this->processPaymentStatus($order, $status_response->transaction_status);
            }
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function success(Order $order)
    {
        $categories = \App\Models\Category::all();
        return view('checkout.success', compact('order', 'categories'));
    }

    /**
     * Process payment status update from Midtrans.
     * Extracted to avoid code duplication between callback() and sync().
     */
    private function processPaymentStatus(Order $order, string $transaction_status): void
    {
        if ($transaction_status === 'capture' || $transaction_status === 'settlement') {
            $order->update(['status' => 'paid']);
            Pembayaran::where('order_id', $order->id)->update([
                'status_pembayaran' => 'paid',
                'tanggal_bayar'     => now(),
            ]);
            $order->reduceStock();

            // Create Invoice if not exists
            if (!$order->invoice) {
                Invoice::create([
                    'order_id'       => $order->id,
                    'invoice_number' => Invoice::generateInvoiceNumber(),
                ]);
            }
        } elseif (in_array($transaction_status, ['cancel', 'deny', 'expire'])) {
            $order->update(['status' => 'failed']);
            Pembayaran::where('order_id', $order->id)->update([
                'status_pembayaran' => 'failed',
            ]);
        } elseif ($transaction_status === 'pending') {
            $order->update(['status' => 'pending']);
        }
    }
}
