<?php

namespace App\Http\Controllers\Admin\Sales;

use App\Http\Controllers\Controller;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class OrderItemController extends Controller
{
    public function index(Request $request)
    {
        $query = OrderItem::with(['order', 'product', 'customRequest']);

        if ($request->filled('order_id')) {
            $query->where('order_id', $request->order_id);
        }

        $orderItems = $query->latest()->paginate(15);
        return view('admin.sales.order-items.index', compact('orderItems'));
    }
}
