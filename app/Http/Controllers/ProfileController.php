<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Order;

class ProfileController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        
        $user = auth()->user()->load(['orders' => function($q) {
            $q->latest()->with(['pembayaran', 'pengiriman', 'items.product']);
        }]);

        return view('profile.index', compact('categories', 'user'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'no_hp' => 'nullable|string|max:20',
            'alamat' => 'nullable|string',
        ]);

        auth()->user()->update([
            'no_hp' => $request->no_hp,
            'alamat' => $request->alamat,
        ]);

        return back()->with('success', 'Informasi profil berhasil diperbarui.');
    }

    public function confirmReceipt(Order $order)
    {
        // Security check: ensure own order and already shipped
        if ($order->user_id !== auth()->id()) {
             abort(403);
        }

        if (!$order->pengiriman || $order->pengiriman->status_pengiriman !== 'dikirim') {
            return back()->with('error', 'Pesanan belum dalam proses pengiriman atau sudah selesai.');
        }

        // Update shipping status
        $order->pengiriman->update([
            'status_pengiriman' => 'sampai',
            'tanggal_terima' => now()->toDateString()
        ]);

        // Update order status
        $order->update(['status' => 'completed']);

        return back()->with('success', 'Terima kasih! Pesanan telah dikonfirmasi selesai.');
    }
}
