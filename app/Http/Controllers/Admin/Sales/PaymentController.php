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

        if ($request->filled('search')) {
            $search = $request->search;
            $numericSearch = preg_replace('/[^0-9]/', '', $search);

            $query->where(function ($q) use ($search, $numericSearch) {
                $q->where('metode_pembayaran', 'like', "%{$search}%")
                  ->orWhereHas('order', function($oq) use ($search) {
                      $oq->where('customer_name', 'like', "%{$search}%")
                         ->orWhere('id', 'like', "%{$search}%");
                  });

                if (!empty($numericSearch)) {
                    $q->orWhere('id', $numericSearch);
                }
            });
        }

        $pembayaran = $query->latest()->paginate(10);
        return view('admin.sales.payments.index', compact('pembayaran'));
    }

    public function updateStatus(Request $request, Pembayaran $pembayaran)
    {
        $request->validate(['status_pembayaran' => 'required|in:pending,paid']);
        $pembayaran->update(['status_pembayaran' => $request->status_pembayaran]);

        if ($request->status_pembayaran === 'paid' && !$pembayaran->tanggal_bayar) {
            $pembayaran->update(['tanggal_bayar' => now()]);
        }

        return back()->with('success', 'Status pembayaran berhasil diperbarui.');
    }
}
