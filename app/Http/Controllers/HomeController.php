<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        // Fetch dynamic data for landing page
        $categories = Category::all();
        $latestProducts = Product::with('category')->latest()->take(6)->get();

        return view('welcome', compact('categories', 'latestProducts'));
    }

    public function customOrder()
    {
        $categories = Category::all();
        return view('custom.create', compact('categories'));
    }

    public function trackOrder(Request $request)
    {
        $categories = Category::all();
        $order = null;

        if ($request->filled('order_id') && $request->filled('email')) {
            $id = preg_replace('/[^0-9]/', '', $request->order_id);
            
            $order = \App\Models\Order::with(['pembayaran', 'pengiriman.assignedKurir'])
                        ->where('id', $id)
                        ->where('customer_email', $request->email)
                        ->first();
                        
            if(!$order) {
                session()->flash('error', 'Pesanan tidak ditemukan atau email tidak cocok.');
            }
        }

        return view('orders.track', compact('categories', 'order'));
    }
    public function storeCustomOrder(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'whatsapp_number' => 'required|string|max:20',
            'request_details' => 'required|string',
            'request_type' => 'required|string',
        ]);

        \App\Models\CustomRequest::create([
            'user_id' => auth()->id() ?? 1, // Fallback to admin/system user if guest
            'customer_name' => $request->customer_name,
            'customer_phone' => $request->whatsapp_number,
            'keterangan' => $request->request_details,
            'product_category' => $request->request_type,
            'status' => 'pending'
        ]);

        return back()->with('success', 'Permintaan kustom Anda telah terkirim! Tim kami akan segera menghubungi Anda via WhatsApp.');
    }

    public function getCourierLocation(Request $request, $order_id)
    {
        $id = preg_replace('/[^0-9]/', '', $order_id);
        $order = \App\Models\Order::with('pengiriman.assignedKurir')
                    ->where('id', $id)
                    ->where('customer_email', $request->email)
                    ->first();

        if ($order && $order->pengiriman && $order->pengiriman->assignedKurir) {
            $kurir = $order->pengiriman->assignedKurir;
            return response()->json([
                'latitude' => $kurir->latitude,
                'longitude' => $kurir->longitude,
                'status' => $order->pengiriman->status_pengiriman,
                'last_update' => $kurir->updated_at->diffForHumans()
            ]);
        }

        return response()->json(['error' => 'Data tidak ditemukan'], 404);
    }
}
