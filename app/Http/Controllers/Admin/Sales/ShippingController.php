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

        $pengiriman = $query->latest()->paginate(10);
        return view('admin.sales.shipping.index', compact('pengiriman'));
    }

    public function updateStatus(Request $request, Pengiriman $pengiriman)
    {
        $request->validate([
            'status_pengiriman' => 'required|in:pending,dikirim,sampai,dibatalkan',
            'kurir' => 'nullable|string',
            'no_resi' => 'nullable|string',
            'tanggal_kirim' => 'nullable|date',
            'tanggal_terima' => 'nullable|date',
        ]);

        $pengiriman->update($request->only(['status_pengiriman', 'kurir', 'no_resi', 'tanggal_kirim', 'tanggal_terima']));
        return back()->with('success', 'Status pengiriman berhasil diperbarui.');
    }
}
