<?php

namespace App\Http\Controllers\Admin\Sales;

use App\Http\Controllers\Controller;
use App\Models\Pengiriman;
use Illuminate\Http\Request;

class ShippingController extends Controller
{
    public function index(Request $request)
    {
        $query = Pengiriman::with('order.user');

        if ($request->filled('status')) {
            $query->where('status_pengiriman', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $numericSearch = preg_replace('/[^0-9]/', '', $search);

            $query->where(function ($q) use ($search, $numericSearch) {
                $q->where('nama_penerima', 'like', "%{$search}%")
                  ->orWhere('alamat_pengiriman', 'like', "%{$search}%")
                  ->orWhere('kurir', 'like', "%{$search}%")
                  ->orWhere('no_resi', 'like', "%{$search}%")
                  ->orWhereHas('order', function($oq) use ($search) {
                      $oq->where('id', 'like', "%{$search}%");
                  });

                if (!empty($numericSearch)) {
                    $q->orWhere('id', $numericSearch);
                }
            });
        }

        $pengiriman = $query->latest()->paginate(10);
        $kurirs = \App\Models\User::where('role', 'kurir')->get();
        return view('admin.sales.shipping.index', compact('pengiriman', 'kurirs'));
    }

    public function updateStatus(Request $request, Pengiriman $pengiriman)
    {
        $request->validate([
            'status_pengiriman' => 'required|in:pending,dikirim,sampai,dibatalkan',
            'kurir' => 'nullable|string',
            'kurir_id' => 'nullable|exists:users,id',
            'no_resi' => 'nullable|string',
            'tanggal_kirim' => 'nullable|date',
            'tanggal_terima' => 'nullable|date',
        ]);

        $data = $request->only(['status_pengiriman', 'kurir', 'kurir_id', 'no_resi', 'tanggal_kirim', 'tanggal_terima']);

        // Auto-fill dates if not provided
        if ($data['status_pengiriman'] === 'dikirim' && empty($data['tanggal_kirim'])) {
            $data['tanggal_kirim'] = now()->toDateString();
            // Sync Order Status
            $pengiriman->order->update(['status' => 'shipped']);
        }

        if ($data['status_pengiriman'] === 'sampai') {
            if (empty($data['tanggal_terima'])) {
                $data['tanggal_terima'] = now()->toDateString();
            }
            // Sync Order Status
            $pengiriman->order->update(['status' => 'completed']);
        }

        $pengiriman->update($data);
        return back()->with('success', 'Status pengiriman berhasil diperbarui.');
    }
}
