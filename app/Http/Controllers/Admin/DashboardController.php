<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\Pembayaran;
use App\Models\Pengiriman;
use App\Models\CustomRequest;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalOrders = Order::count();
        $totalRevenue = Pembayaran::where('status_pembayaran', 'paid')->sum('jumlah_bayar');
        $totalProducts = Product::count();
        $totalUsers = User::where('role', 'customer')->count();
        $pendingOrders = Order::where('status', 'pending')->count();
        $shippedOrders = Order::where('status', 'shipped')->count();
        $completedOrders = Order::where('status', 'completed')->count();
        $pendingPayments = Pembayaran::where('status_pembayaran', 'pending')->count();
        $pendingShipments = Pengiriman::where('status_pengiriman', 'pending')->count();
        $customRequests = CustomRequest::where('status', 'pending')->count();
        $lowStockProducts = Product::where('stok', '<=', 5)->get();

        $recentOrders = Order::with('user')->latest()->take(3)->get();

        // New Metrics
        $topProducts = OrderItem::with('product')
            ->select('product_id', DB::raw('SUM(jumlah) as total_qty'))
            ->groupBy('product_id')
            ->orderByDesc('total_qty')
            ->take(5)
            ->get();

        $topCategories = OrderItem::join('products', 'order_items.product_id', '=', 'products.id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->select('categories.nama_kategori', DB::raw('SUM(order_items.jumlah) as total_qty'))
            ->groupBy('categories.id', 'categories.nama_kategori')
            ->orderByDesc('total_qty')
            ->get();

        $recentUsers = User::where('role', 'customer')->latest()->take(5)->get();
        $urgentOrdersCount = Order::where('status', 'paid')->count();

        // Monthly revenue for chart (last 6 months)
        $monthlyRevenue = Pembayaran::where('status_pembayaran', 'paid')
            ->where('tanggal_bayar', '>=', now()->subMonths(6))
            ->selectRaw("DATE_FORMAT(tanggal_bayar, '%Y-%m') as month, SUM(jumlah_bayar) as total")
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Order status distribution
        $orderStatuses = Order::selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->get();

        return view('admin.dashboard', compact(
            'totalOrders', 'totalRevenue', 'totalProducts', 'totalUsers',
            'pendingOrders', 'shippedOrders', 'completedOrders',
            'pendingPayments', 'pendingShipments', 'customRequests', 'lowStockProducts',
            'recentOrders', 'monthlyRevenue', 'orderStatuses',
            'topProducts', 'topCategories', 'recentUsers', 'urgentOrdersCount'
        ));
    }
}
