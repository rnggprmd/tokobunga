<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::all();
        $query = Product::query()->with('category');

        // filled() checks key exists AND value is not empty (vs has() which only checks key exists)
        if ($request->filled('category')) {
            $query->where('category_id', (int) $request->category);
        }

        if ($request->filled('search')) {
            $query->where('nama_produk', 'like', '%' . $request->search . '%');
        }

        $products = $query->latest()->paginate(12);

        return view('products.index', compact('products', 'categories'));
    }

    public function show(Product $product)
    {
        $categories = Category::all();
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->take(4)
            ->get();

        $product->load(['reviews' => function($q) {
            $q->where('is_visible', true)->latest()->with('user');
        }]);

        return view('products.show', compact('product', 'categories', 'relatedProducts'));
    }
}
