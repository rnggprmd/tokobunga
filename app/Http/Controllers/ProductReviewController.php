<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductReview;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class ProductReviewController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:500',
        ]);

        // Check the number of completed orders with this product
        $purchaseCount = Order::where('user_id', Auth::id())
            ->where('status', 'completed')
            ->whereHas('items', function ($query) use ($request) {
                $query->where('product_id', $request->product_id);
            })
            ->count();

        if ($purchaseCount === 0) {
            return back()->with('error', 'Anda hanya dapat memberikan ulasan untuk produk yang telah Anda beli dan selesaikan.');
        }

        // Check the number of reviews already given
        $reviewCount = ProductReview::where('user_id', Auth::id())
            ->where('product_id', $request->product_id)
            ->count();

        if ($reviewCount >= $purchaseCount) {
            return back()->with('error', 'Kuota ulasan habis! Semua pesanan Anda yang telah selesai untuk produk ini sudah Anda berikan ulasan.');
        }

        ProductReview::create([
            'user_id' => Auth::id(),
            'product_id' => $request->product_id,
            'rating' => $request->rating,
            'comment' => $request->comment,
            'is_visible' => true,
        ]);

        return back()->with('success', 'Terima kasih atas ulasan Anda! Kontribusi Anda sangat berharga bagi kami.');
    }
}
