<?php

namespace App\Http\Controllers\Admin\Sales;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

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

    public function show(Order $order)
    {
        $order->load(['user', 'items.product', 'items.variant', 'pembayaran', 'pengiriman']);
        return view('admin.sales.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate(['status' => 'required|in:pending,paid,success,failed,expired,cancelled,challenge,shipped,completed']);
        $order->update(['status' => $request->status]);
        return back()->with('success', 'Status order berhasil diperbarui.');
    }
}
