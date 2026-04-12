<?php

namespace App\Http\Controllers\Admin\Sales;

use App\Http\Controllers\Controller;
use App\Models\Pembayaran;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $query = Pembayaran::with('order.user');

        if ($request->filled('status')) {
            $query->where('status_pembayaran', $request->status);
        }

        $pembayaran = $query->latest()->paginate(10);
        return view('admin.sales.payments.index', compact('pembayaran'));
    }

    public function updateStatus(Request $request, Pembayaran $pembayaran)
    {
        $request->validate(['status_pembayaran' => 'required|in:pending,paid,failed,refund']);
        $pembayaran->update(['status_pembayaran' => $request->status_pembayaran]);

        if ($request->status_pembayaran === 'paid' && !$pembayaran->tanggal_bayar) {
            $pembayaran->update(['tanggal_bayar' => now()]);
        }

        return back()->with('success', 'Status pembayaran berhasil diperbarui.');
    }
}
