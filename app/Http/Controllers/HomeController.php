<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        // Fetch dynamic data for landing page
        $categories = Category::all();
        $latestProducts = Product::with('category')->latest()->take(6)->get();

        return view('welcome', compact('categories', 'latestProducts'));
    }

    public function customOrder()
    {
        $categories = Category::all();
        return view('custom.create', compact('categories'));
    }

    public function trackOrder()
    {
        $categories = Category::all();
        return view('orders.track', compact('categories'));
    }
}
