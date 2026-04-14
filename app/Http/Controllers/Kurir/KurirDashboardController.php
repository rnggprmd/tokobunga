<?php

namespace App\Http\Controllers\Kurir;

use App\Http\Controllers\Controller;
use App\Models\Pengiriman;

class KurirDashboardController extends Controller
{
    public function index()
    {
        $kurirId = auth()->id();

        $totalTugas = Pengiriman::where('kurir_id', $kurirId)->count();
        $sedangDiantar = Pengiriman::where('kurir_id', $kurirId)
            ->where('status_pengiriman', 'dikirim')->count();
        $selesai = Pengiriman::where('kurir_id', $kurirId)
            ->where('status_pengiriman', 'sampai')->count();
        $menunggu = Pengiriman::where('kurir_id', $kurirId)
            ->whereNotIn('status_pengiriman', ['dikirim', 'sampai'])->count();

        $recentPengiriman = Pengiriman::with('order')
            ->where('kurir_id', $kurirId)
            ->latest()
            ->take(5)
            ->get();

        return view('kurir.dashboard', compact(
            'totalTugas', 'sedangDiantar', 'selesai', 'menunggu', 'recentPengiriman'
        ));
    }
}
