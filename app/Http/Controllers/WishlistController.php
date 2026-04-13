<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        $wishlistItems = Wishlist::where('user_id', Auth::id())
            ->with('product.category')
            ->latest()
            ->get();

        return view('wishlist.index', compact('categories', 'wishlistItems'));
    }

    public function toggle(Product $product)
    {
        $wishlist = Wishlist::where('user_id', Auth::id())
            ->where('product_id', $product->id)
            ->first();

        if ($wishlist) {
            $wishlist->delete();
            $message = 'Produk dihapus dari wishlist.';
            $type = 'success';
        } else {
            Wishlist::create([
                'user_id' => Auth::id(),
                'product_id' => $product->id
            ]);
            $message = 'Produk ditambahkan ke wishlist.';
            $type = 'success';
        }

        if (request()->ajax()) {
            return response()->json(['message' => $message, 'status' => 'success']);
        }

        return back()->with($type, $message);
    }

    public function remove(Wishlist $wishlist)
    {
        if ($wishlist->user_id !== Auth::id()) {
            abort(403);
        }

        $wishlist->delete();
        return back()->with('success', 'Produk dihapus dari wishlist.');
    }
}
