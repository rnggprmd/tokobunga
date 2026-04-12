<?php

namespace App\Http\Controllers\Admin\Catalog;

use App\Http\Controllers\Controller;
use App\Models\ProductVariant;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductVariantController extends Controller
{
    public function index(Request $request)
    {
        $query = ProductVariant::with('product.category');

        if ($request->filled('product_id')) {
            $query->where('product_id', $request->product_id);
        }

        $variants = $query->latest()->paginate(15);
        $products = Product::all();
        return view('admin.catalog.variants.index', compact('variants', 'products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'size' => 'required|string|max:255',
            'stock' => 'required|integer|min:0',
            'price_adjustment' => 'required|numeric|min:0',
        ]);

        ProductVariant::create($request->only(['product_id', 'size', 'stock', 'price_adjustment']));
        return back()->with('success', 'Varian produk berhasil ditambahkan.');
    }

    public function update(Request $request, ProductVariant $variant)
    {
        $request->validate([
            'size' => 'required|string|max:255',
            'stock' => 'required|integer|min:0',
            'price_adjustment' => 'required|numeric|min:0',
        ]);

        $variant->update($request->only(['size', 'stock', 'price_adjustment']));
        return back()->with('success', 'Varian produk berhasil diperbarui.');
    }

    public function destroy(ProductVariant $variant)
    {
        $variant->delete();
        return back()->with('success', 'Varian produk berhasil dihapus.');
    }
}
