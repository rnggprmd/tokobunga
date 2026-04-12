<?php

namespace App\Http\Controllers\Admin\Analytics;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Pembayaran;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index()
    {
        // Monthly revenue (last 12 months)
        $monthlyRevenue = Pembayaran::where('status_pembayaran', 'paid')
            ->where('tanggal_bayar', '>=', now()->subMonths(12))
            ->selectRaw("DATE_FORMAT(tanggal_bayar, '%Y-%m') as month, SUM(jumlah_bayar) as total")
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Order count by status
        $orderByStatus = Order::selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->get();

        // Top products by order count
        $topProducts = DB::table('order_items')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->selectRaw('products.nama_produk, SUM(order_items.jumlah) as total_sold, SUM(order_items.subtotal) as total_revenue')
            ->groupBy('products.id', 'products.nama_produk')
            ->orderByDesc('total_sold')
            ->limit(10)
            ->get();

        // Total stats
        $totalRevenue = Pembayaran::where('status_pembayaran', 'paid')->sum('jumlah_bayar');
        $totalOrders = Order::count();
        $avgOrderValue = $totalOrders > 0 ? $totalRevenue / $totalOrders : 0;

        return view('admin.analytics.reports.index', compact(
            'monthlyRevenue', 'orderByStatus', 'topProducts',
            'totalRevenue', 'totalOrders', 'avgOrderValue'
        ));
    }
}
