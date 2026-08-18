<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        $cart = session()->get('cart', []);
        
        $total = 0;
        foreach($cart as $item) {
            $total += $item['harga'] * $item['quantity'];
        }

        return view('cart.index', compact('categories', 'cart', 'total'));
    }

    public function add(Product $product)
    {
        if ($product->stok <= 0) {
            return redirect()->back()->with('error', 'Maaf, stok produk ini sedang habis.');
        }

        $cart = session()->get('cart', []);

        $currentQty = isset($cart[$product->id]) ? $cart[$product->id]['quantity'] : 0;
        if ($currentQty + 1 > $product->stok) {
            return redirect()->back()->with('error', "Jumlah di keranjang melebihi stok yang tersedia (tersedia: {$product->stok}).");
        }

        if(isset($cart[$product->id])) {
            $cart[$product->id]['quantity']++;
        } else {
            $cart[$product->id] = [
                "nama" => $product->nama_produk,
                "quantity" => 1,
                "harga" => $product->harga,
                "foto" => $product->foto
            ];
        }

        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Produk berhasil ditambahkan ke keranjang!');
    }

    public function decrement($id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            if ($cart[$id]['quantity'] > 1) {
                $cart[$id]['quantity']--;
                session()->put('cart', $cart);
                return redirect()->back()->with('success', 'Jumlah produk berhasil dikurangi.');
            } else {
                unset($cart[$id]);
                session()->put('cart', $cart);
                return redirect()->back()->with('success', 'Produk berhasil dihapus dari keranjang!');
            }
        }

        return redirect()->back();
    }

    public function remove($id)
    {
        $cart = session()->get('cart', []);

        if(isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        return redirect()->back()->with('success', 'Produk berhasil dihapus dari keranjang!');
    }
}
