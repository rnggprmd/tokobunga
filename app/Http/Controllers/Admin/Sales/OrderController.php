<?php

namespace App\Http\Controllers\Admin\Sales;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\User;
use App\Models\Pembayaran;
use App\Models\Pengiriman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with(['user', 'pembayaran', 'pengiriman']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('customer_name', 'like', "%{$request->search}%")
                  ->orWhere('id', $request->search);
            });
        }

        $orders = $query->latest()->paginate(10);
        return view('admin.sales.orders.index', compact('orders'));
    }

    public function create()
    {
        $products = Product::with('variants')->where('tipe_produk', 'ready')->get();
        $users = User::where('role', 'customer')->get();
        return view('admin.sales.orders.create', compact('products', 'users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'nullable|exists:users,id',
            'customer_name' => 'required_without:user_id|string|max:255',
            'customer_email' => 'nullable|email|max:255',
            'customer_phone' => 'nullable|string|max:20',
            'alamat_pengiriman' => 'nullable|string',
            'ucapan' => 'nullable|string|max:1000',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.variant_id' => 'nullable|exists:product_variants,id',
            'items.*.jumlah' => 'required|integer|min:1',
            'metode_pembayaran' => 'nullable|string',
        ]);

        return DB::transaction(function () use ($request) {
            $total_harga = 0;
            $orderItemsData = [];

            foreach ($request->items as $item) {
                $product = Product::findOrFail($item['product_id']);
                $harga_satuan = $product->harga;
                
                if (!empty($item['variant_id'])) {
                    $variant = ProductVariant::findOrFail($item['variant_id']);
                    $harga_satuan += $variant->price_adjustment;
                }

                $subtotal = $harga_satuan * $item['jumlah'];
                $total_harga += $subtotal;

                $orderItemsData[] = [
                    'product_id' => $item['product_id'],
                    'variant_id' => $item['variant_id'] ?? null,
                    'jumlah' => $item['jumlah'],
                    'harga_satuan' => $harga_satuan,
                    'subtotal' => $subtotal,
                    'harga' => $subtotal, // Assuming 'harga' in order_items is subtotal
                ];
            }

            $orderData = $request->only(['user_id', 'customer_name', 'customer_email', 'customer_phone', 'alamat_pengiriman', 'ucapan', 'metode_pembayaran']);
            $orderData['total_harga'] = $total_harga;
            $orderData['status'] = 'pending';

            if ($request->filled('user_id') && empty($orderData['customer_name'])) {
                $user = User::find($request->user_id);
                $orderData['customer_name'] = $user->name;
                $orderData['customer_email'] = $user->email;
                $orderData['customer_phone'] = $user->no_hp;
            }

            $order = Order::create($orderData);

            foreach ($orderItemsData as $itemData) {
                $itemData['order_id'] = $order->id;
                OrderItem::create($itemData);
            }

            return redirect()->route('admin.orders.show', $order)->with('success', 'Order berhasil dibuat.');
        });
    }

    public function show(Order $order)
    {
        $order->load(['user', 'items.product', 'items.variant', 'pembayaran', 'pengiriman']);
        return view('admin.sales.orders.show', compact('order'));
    }

    public function edit(Order $order)
    {
        // For simplicity, we might only allow editing basic info or status here
        // Usually, complex order editing requires a special UI
        return view('admin.sales.orders.edit', compact('order'));
    }

    public function update(Request $request, Order $order)
    {
        $order->update($request->all());
        return redirect()->route('admin.orders.show', $order)->with('success', 'Order berhasil diperbarui.');
    }

    public function destroy(Order $order)
    {
        $order->delete();
        return redirect()->route('admin.orders.index')->with('success', 'Order telah dihapus.');
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate(['status' => 'required|in:pending,paid,success,failed,expired,cancelled,challenge,shipped,completed']);
        $order->update(['status' => $request->status]);
        return back()->with('success', 'Status order berhasil diperbarui.');
    }

    public function storePayment(Request $request, Order $order)
    {
        $request->validate([
            'metode_pembayaran' => 'required|string',
            'jumlah_bayar' => 'required|numeric|min:0',
            'status_pembayaran' => 'required|in:pending,paid,failed,refund',
            'bukti_bayar' => 'nullable|image|max:2048',
        ]);

        $data = $request->only(['metode_pembayaran', 'jumlah_bayar', 'status_pembayaran']);
        $data['order_id'] = $order->id;
        
        if ($request->status_pembayaran === 'paid') {
            $data['tanggal_bayar'] = now();
            $order->update(['status' => 'paid']);
        }

        if ($request->hasFile('bukti_bayar')) {
            $data['bukti_bayar'] = $request->file('bukti_bayar')->store('payments', 'public');
        }

        Pembayaran::updateOrCreate(['order_id' => $order->id], $data);

        return back()->with('success', 'Data pembayaran berhasil disimpan.');
    }

    public function storeShipping(Request $request, Order $order)
    {
        $request->validate([
            'kurir' => 'required|string',
            'no_resi' => 'nullable|string',
            'status_pengiriman' => 'required|in:pending,dikirim,sampai,dibatalkan',
            'tanggal_kirim' => 'nullable|date',
        ]);

        $data = $request->only(['kurir', 'no_resi', 'status_pengiriman', 'tanggal_kirim']);
        $data['order_id'] = $order->id;
        $data['nama_penerima'] = $order->customer_name;
        $data['alamat_pengiriman'] = $order->alamat_pengiriman;
        $data['no_hp'] = $order->customer_phone ?? '-';

        if ($request->status_pengiriman === 'dikirim') {
            $order->update(['status' => 'shipped']);
        } elseif ($request->status_pengiriman === 'sampai') {
            $order->update(['status' => 'completed']);
        }

        Pengiriman::updateOrCreate(['order_id' => $order->id], $data);

        return back()->with('success', 'Data pengiriman berhasil disimpan.');
    }
}
