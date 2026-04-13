<?php

namespace App\Http\Controllers\Admin\Catalog;

use App\Http\Controllers\Controller;
use App\Models\ProductReview;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index()
    {
        $reviews = ProductReview::with(['user', 'product'])
            ->latest()
            ->paginate(15);

        return view('admin.catalog.reviews.index', compact('reviews'));
    }

    public function toggleVisibility(ProductReview $review)
    {
        $review->update([
            'is_visible' => !$review->is_visible
        ]);

        return back()->with('success', 'Status visibilitas ulasan berhasil diperbarui.');
    }

    public function destroy(ProductReview $review)
    {
        $review->delete();

        return back()->with('success', 'Ulasan berhasil dihapus.');
    }
}
