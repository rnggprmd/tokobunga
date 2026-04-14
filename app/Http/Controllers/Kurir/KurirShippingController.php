<?php

namespace App\Http\Controllers\Kurir;

use App\Http\Controllers\Controller;
use App\Models\Pengiriman;
use Illuminate\Http\Request;

class KurirShippingController extends Controller
{
    public function index(Request $request)
    {
        $query = Pengiriman::with(['order', 'order.user'])
            ->where('kurir_id', auth()->id());

        if ($request->filled('status')) {
            $query->where('status_pengiriman', $request->status);
        } else {
            // Default: Only show active tasks (exclude sampai)
            $query->whereIn('status_pengiriman', ['pending', 'dikirim']);
        }

        $pengirimanList = $query->latest()->paginate(15);

        return view('kurir.pengiriman.index', compact('pengirimanList'));
    }

    public function history(Request $request)
    {
        $query = Pengiriman::with(['order', 'order.user'])
            ->where('kurir_id', auth()->id())
            ->where('status_pengiriman', 'sampai');

        $pengirimanList = $query->latest()->paginate(15);

        return view('kurir.pengiriman.history', compact('pengirimanList'));
    }

    public function proses(Pengiriman $pengiriman)
    {
        if ($pengiriman->kurir_id !== auth()->id()) {
            abort(403);
        }

        $pengiriman->update([
            'status_pengiriman' => 'dikirim',
            'tanggal_kirim' => now(),
        ]);

        if ($pengiriman->order) {
            $pengiriman->order->update(['status' => 'shipped']);
        }

        return back()->with('success', 'Status pengiriman diperbarui: Sedang Dikirim.');
    }

    public function selesai(Pengiriman $pengiriman)
    {
        if ($pengiriman->kurir_id !== auth()->id()) {
            abort(403);
        }

        $pengiriman->update([
            'status_pengiriman' => 'sampai',
            'tanggal_terima' => now(),
        ]);

        // Update order status to completed
        if ($pengiriman->order) {
            $pengiriman->order->update(['status' => 'completed']);
        }

        return back()->with('success', 'Pesanan berhasil ditandai Selesai!');
    }

    public function updateLocation(Request $request)
    {
        $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        auth()->user()->update([
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
        ]);

        return response()->json(['success' => true]);
    }
}
