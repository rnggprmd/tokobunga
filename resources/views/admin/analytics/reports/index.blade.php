@extends('admin.layouts.app')
@section('title', 'Laporan & Statistik')
@section('subtitle', 'Analisis performa penjualan toko')

@section('content')
<div class="space-y-8">
    {{-- Summary Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="glass-card rounded-2xl p-6 stat-card animate-fade-in">
            <div class="flex items-center justify-between mb-3">
                <div class="w-11 h-11 bg-accent-gold/10 rounded-xl flex items-center justify-center">
                    <span class="material-symbols-outlined text-accent-gold">account_balance_wallet</span>
                </div>
                <span class="text-[10px] uppercase tracking-[0.15em] text-accent-gold font-semibold">Total Revenue</span>
            </div>
            <p class="text-3xl font-bold text-accent-gold">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
            <p class="text-xs text-text-muted mt-1">Dari semua pembayaran lunas</p>
        </div>
        <div class="glass-card rounded-2xl p-6 stat-card animate-fade-in-delay-1">
            <div class="flex items-center justify-between mb-3">
                <div class="w-11 h-11 bg-accent-emerald/10 rounded-xl flex items-center justify-center">
                    <span class="material-symbols-outlined text-accent-emerald">shopping_cart</span>
                </div>
                <span class="text-[10px] uppercase tracking-[0.15em] text-accent-emerald font-semibold">Total Order</span>
            </div>
            <p class="text-3xl font-bold">{{ number_format($totalOrders) }}</p>
            <p class="text-xs text-text-muted mt-1">Semua pesanan masuk</p>
        </div>
        <div class="glass-card rounded-2xl p-6 stat-card animate-fade-in-delay-2">
            <div class="flex items-center justify-between mb-3">
                <div class="w-11 h-11 bg-accent-rose/10 rounded-xl flex items-center justify-center">
                    <span class="material-symbols-outlined text-accent-rose">avg_pace</span>
                </div>
                <span class="text-[10px] uppercase tracking-[0.15em] text-accent-rose font-semibold">Rata-rata</span>
            </div>
            <p class="text-3xl font-bold">Rp {{ number_format($avgOrderValue, 0, ',', '.') }}</p>
            <p class="text-xs text-text-muted mt-1">Rata-rata nilai order</p>
        </div>
    </div>

    {{-- Charts --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        {{-- Revenue Trend --}}
        <div class="glass-card rounded-2xl p-6">
            <h3 class="text-lg font-semibold mb-1 flex items-center gap-2">
                <span class="material-symbols-outlined text-accent-emerald">show_chart</span>
                Tren Revenue Bulanan
            </h3>
            <p class="text-xs text-text-muted mb-6">Data 12 bulan terakhir</p>
            <canvas id="revenueLineChart" height="160"></canvas>
        </div>

        {{-- Order Distribution --}}
        <div class="glass-card rounded-2xl p-6">
            <h3 class="text-lg font-semibold mb-1 flex items-center gap-2">
                <span class="material-symbols-outlined text-accent-gold">donut_large</span>
                Distribusi Status Order
            </h3>
            <p class="text-xs text-text-muted mb-6">Semua order berdasarkan status</p>
            <canvas id="orderPieChart" height="160"></canvas>
        </div>
    </div>

    {{-- Top Products --}}
    <div class="glass-card rounded-2xl overflow-hidden">
        <div class="px-6 py-5 border-b border-admin-border">
            <h3 class="text-lg font-semibold flex items-center gap-2">
                <span class="material-symbols-outlined text-accent-rose">emoji_events</span>
                Produk Terlaris
            </h3>
            <p class="text-xs text-text-muted mt-1">Ranking berdasarkan jumlah penjualan</p>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-text-muted text-xs uppercase tracking-wider bg-admin-bg/50">
                        <th class="text-left px-6 py-4">Rank</th>
                        <th class="text-left px-6 py-4">Produk</th>
                        <th class="text-left px-6 py-4">Total Terjual</th>
                        <th class="text-left px-6 py-4">Total Revenue</th>
                        <th class="text-left px-6 py-4">Progress</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-admin-border/50">
                    @php $maxSold = $topProducts->max('total_sold') ?: 1; @endphp
                    @forelse($topProducts as $i => $tp)
                    <tr class="hover:bg-admin-card-hover/50 transition-colors">
                        <td class="px-6 py-4">
                            @if($i < 3)
                                <span class="w-7 h-7 flex items-center justify-center rounded-full text-xs font-bold
                                    {{ $i == 0 ? 'bg-yellow-500/20 text-yellow-400' : ($i == 1 ? 'bg-gray-400/20 text-gray-300' : 'bg-orange-500/20 text-orange-400') }}">
                                    {{ $i + 1 }}
                                </span>
                            @else
                                <span class="text-text-muted pl-2">{{ $i + 1 }}</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 font-medium">{{ $tp->nama_produk }}</td>
                        <td class="px-6 py-4">{{ number_format($tp->total_sold) }} unit</td>
                        <td class="px-6 py-4 text-accent-gold font-medium">Rp {{ number_format($tp->total_revenue, 0, ',', '.') }}</td>
                        <td class="px-6 py-4 w-48">
                            <div class="w-full bg-admin-bg rounded-full h-2">
                                <div class="bg-gradient-to-r from-accent-emerald to-accent-gold h-2 rounded-full transition-all duration-700"
                                    style="width: {{ ($tp->total_sold / $maxSold) * 100 }}%"></div>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="text-center py-12 text-text-muted">Belum ada data penjualan</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Revenue Line Chart
    const rlCtx = document.getElementById('revenueLineChart').getContext('2d');
    const rlGradient = rlCtx.createLinearGradient(0, 0, 0, 300);
    rlGradient.addColorStop(0, 'rgba(52, 211, 153, 0.25)');
    rlGradient.addColorStop(1, 'rgba(52, 211, 153, 0.01)');

    new Chart(rlCtx, {
        type: 'line',
        data: {
            labels: {!! json_encode($monthlyRevenue->pluck('month')) !!},
            datasets: [{
                label: 'Revenue',
                data: {!! json_encode($monthlyRevenue->pluck('total')) !!},
                borderColor: '#34d399',
                backgroundColor: rlGradient,
                borderWidth: 2.5,
                fill: true,
                tension: 0.4,
                pointBackgroundColor: '#34d399',
                pointBorderWidth: 0,
                pointRadius: 5,
                pointHoverRadius: 7,
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#1a1f2e', borderColor: '#2a3042', borderWidth: 1,
                    titleColor: '#e8eaf0', bodyColor: '#8b92a8',
                    callbacks: { label: (ctx) => 'Rp ' + Number(ctx.raw).toLocaleString('id-ID') }
                }
            },
            scales: {
                x: { grid: { color: 'rgba(42,48,66,0.3)' }, ticks: { color: '#5a6278', font: { size: 11 } } },
                y: { grid: { color: 'rgba(42,48,66,0.3)' }, ticks: { color: '#5a6278', font: { size: 11 }, callback: v => 'Rp ' + (v/1000) + 'k' } }
            }
        }
    });

    // Order Status Pie Chart
    const opCtx = document.getElementById('orderPieChart').getContext('2d');
    new Chart(opCtx, {
        type: 'doughnut',
        data: {
            labels: {!! json_encode($orderByStatus->pluck('status')->map(fn($s) => ucfirst($s))) !!},
            datasets: [{
                data: {!! json_encode($orderByStatus->pluck('count')) !!},
                backgroundColor: ['#eab308', '#3b82f6', '#34d399', '#ef4444', '#a855f7', '#f97316', '#6366f1', '#ec4899', '#14b8a6'],
                borderColor: '#141820',
                borderWidth: 4,
            }]
        },
        options: {
            responsive: true,
            cutout: '60%',
            plugins: {
                legend: {
                    position: 'right',
                    labels: { color: '#8b92a8', padding: 16, font: { size: 12 }, usePointStyle: true, pointStyleWidth: 10 }
                }
            }
        }
    });
</script>
@endpush
