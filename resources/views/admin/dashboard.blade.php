@extends('admin.layouts.app')
@section('title', 'Dashboard')
@section('subtitle', 'Ringkasan performa toko Mbah Bibit')

@section('content')
<div class="space-y-8">
    {{-- Stat Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="glass-card stat-card rounded-2xl p-6 animate-fade-in">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-accent-emerald/10 rounded-xl flex items-center justify-center">
                    <span class="material-symbols-outlined text-accent-emerald text-2xl">shopping_cart</span>
                </div>
                <span class="text-xs text-accent-emerald bg-accent-emerald/10 px-2 py-1 rounded-full font-medium">Total</span>
            </div>
            <p class="text-3xl font-bold">{{ number_format($totalOrders) }}</p>
            <p class="text-sm text-text-muted mt-1">Total Orders</p>
        </div>

        <div class="glass-card stat-card rounded-2xl p-6 animate-fade-in-delay-1">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-accent-gold/10 rounded-xl flex items-center justify-center">
                    <span class="material-symbols-outlined text-accent-gold text-2xl">account_balance_wallet</span>
                </div>
                <span class="text-xs text-accent-gold bg-accent-gold/10 px-2 py-1 rounded-full font-medium">Revenue</span>
            </div>
            <p class="text-3xl font-bold">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
            <p class="text-sm text-text-muted mt-1">Total Pendapatan</p>
        </div>

        <div class="glass-card stat-card rounded-2xl p-6 animate-fade-in-delay-2">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-accent-rose/10 rounded-xl flex items-center justify-center">
                    <span class="material-symbols-outlined text-accent-rose text-2xl">local_florist</span>
                </div>
                <span class="text-xs text-accent-rose bg-accent-rose/10 px-2 py-1 rounded-full font-medium">Katalog</span>
            </div>
            <p class="text-3xl font-bold">{{ number_format($totalProducts) }}</p>
            <p class="text-sm text-text-muted mt-1">Total Produk</p>
        </div>

        <div class="glass-card stat-card rounded-2xl p-6 animate-fade-in-delay-3">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-blue-500/10 rounded-xl flex items-center justify-center">
                    <span class="material-symbols-outlined text-blue-400 text-2xl">group</span>
                </div>
                <span class="text-xs text-blue-400 bg-blue-500/10 px-2 py-1 rounded-full font-medium">Users</span>
            </div>
            <p class="text-3xl font-bold">{{ number_format($totalUsers) }}</p>
            <p class="text-sm text-text-muted mt-1">Total Pelanggan</p>
        </div>
    </div>

    {{-- Quick Status --}}
    <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
        <div class="glass-card rounded-xl p-4 text-center">
            <p class="text-2xl font-bold text-yellow-400">{{ $pendingOrders }}</p>
            <p class="text-xs text-text-muted mt-1">Order Pending</p>
        </div>
        <div class="glass-card rounded-xl p-4 text-center">
            <p class="text-2xl font-bold text-blue-400">{{ $shippedOrders }}</p>
            <p class="text-xs text-text-muted mt-1">Sedang Dikirim</p>
        </div>
        <div class="glass-card rounded-xl p-4 text-center">
            <p class="text-2xl font-bold text-accent-emerald">{{ $completedOrders }}</p>
            <p class="text-xs text-text-muted mt-1">Selesai</p>
        </div>
        <div class="glass-card rounded-xl p-4 text-center">
            <p class="text-2xl font-bold text-orange-400">{{ $pendingPayments }}</p>
            <p class="text-xs text-text-muted mt-1">Bayar Pending</p>
        </div>
        <div class="glass-card rounded-xl p-4 text-center">
            <p class="text-2xl font-bold text-purple-400">{{ $customRequests }}</p>
            <p class="text-xs text-text-muted mt-1">Custom Request</p>
        </div>
    </div>

    {{-- Charts Row --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 glass-card rounded-2xl p-6">
            <h3 class="text-lg font-semibold mb-4 flex items-center gap-2">
                <span class="material-symbols-outlined text-accent-emerald">trending_up</span>
                Revenue Bulanan
            </h3>
            <canvas id="revenueChart" height="120"></canvas>
        </div>
        <div class="glass-card rounded-2xl p-6">
            <h3 class="text-lg font-semibold mb-4 flex items-center gap-2">
                <span class="material-symbols-outlined text-accent-gold">pie_chart</span>
                Status Order
            </h3>
            <canvas id="statusChart" height="200"></canvas>
        </div>
    </div>

    {{-- Recent Orders --}}
    <div class="glass-card rounded-2xl p-6">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-lg font-semibold flex items-center gap-2">
                <span class="material-symbols-outlined text-accent-rose">history</span>
                Order Terbaru
            </h3>
            <a href="{{ route('admin.orders.index') }}" class="text-sm text-accent-emerald hover:underline">Lihat Semua →</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-text-muted text-xs uppercase tracking-wider border-b border-admin-border">
                        <th class="text-left pb-3 pr-4">ID</th>
                        <th class="text-left pb-3 pr-4">Customer</th>
                        <th class="text-left pb-3 pr-4">Total</th>
                        <th class="text-left pb-3 pr-4">Status</th>
                        <th class="text-left pb-3">Tanggal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-admin-border/50">
                    @forelse($recentOrders as $order)
                    <tr class="hover:bg-admin-card-hover/50 transition-colors">
                        <td class="py-3 pr-4 font-mono text-text-muted">#{{ $order->id }}</td>
                        <td class="py-3 pr-4">{{ $order->customer_name ?? ($order->user->name ?? '-') }}</td>
                        <td class="py-3 pr-4 font-medium">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</td>
                        <td class="py-3 pr-4">
                            @php
                                $colors = [
                                    'pending' => 'bg-yellow-500/10 text-yellow-400',
                                    'paid' => 'bg-blue-500/10 text-blue-400',
                                    'shipped' => 'bg-purple-500/10 text-purple-400',
                                    'completed' => 'bg-emerald-500/10 text-emerald-400',
                                    'cancelled' => 'bg-red-500/10 text-red-400',
                                    'failed' => 'bg-red-500/10 text-red-400',
                                ];
                                $color = $colors[$order->status] ?? 'bg-gray-500/10 text-gray-400';
                            @endphp
                            <span class="px-2.5 py-1 rounded-full text-xs font-medium {{ $color }}">{{ ucfirst($order->status) }}</span>
                        </td>
                        <td class="py-3 text-text-muted">{{ $order->created_at->format('d M Y') }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="text-center py-8 text-text-muted">Belum ada order</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Revenue Chart
    const revenueCtx = document.getElementById('revenueChart').getContext('2d');
    const gradient = revenueCtx.createLinearGradient(0, 0, 0, 250);
    gradient.addColorStop(0, 'rgba(52, 211, 153, 0.3)');
    gradient.addColorStop(1, 'rgba(52, 211, 153, 0.01)');

    new Chart(revenueCtx, {
        type: 'line',
        data: {
            labels: {!! json_encode($monthlyRevenue->pluck('month')) !!},
            datasets: [{
                label: 'Revenue',
                data: {!! json_encode($monthlyRevenue->pluck('total')) !!},
                borderColor: '#34d399',
                backgroundColor: gradient,
                borderWidth: 2,
                fill: true,
                tension: 0.4,
                pointBackgroundColor: '#34d399',
                pointBorderWidth: 0,
                pointRadius: 4,
                pointHoverRadius: 6,
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#1a1f2e',
                    borderColor: '#2a3042',
                    borderWidth: 1,
                    titleColor: '#e8eaf0',
                    bodyColor: '#8b92a8',
                    callbacks: { label: (ctx) => 'Rp ' + Number(ctx.raw).toLocaleString('id-ID') }
                }
            },
            scales: {
                x: { grid: { color: 'rgba(42,48,66,0.3)' }, ticks: { color: '#5a6278', font: { size: 11 } } },
                y: { grid: { color: 'rgba(42,48,66,0.3)' }, ticks: { color: '#5a6278', font: { size: 11 }, callback: v => 'Rp ' + (v/1000) + 'k' } }
            }
        }
    });

    // Status Pie Chart
    const statusCtx = document.getElementById('statusChart').getContext('2d');
    new Chart(statusCtx, {
        type: 'doughnut',
        data: {
            labels: {!! json_encode($orderStatuses->pluck('status')->map(fn($s) => ucfirst($s))) !!},
            datasets: [{
                data: {!! json_encode($orderStatuses->pluck('count')) !!},
                backgroundColor: ['#eab308', '#3b82f6', '#34d399', '#ef4444', '#a855f7', '#f97316', '#6366f1', '#ec4899', '#14b8a6'],
                borderColor: '#141820',
                borderWidth: 3,
            }]
        },
        options: {
            responsive: true,
            cutout: '65%',
            plugins: {
                legend: { position: 'bottom', labels: { color: '#8b92a8', padding: 12, font: { size: 11 }, usePointStyle: true, pointStyleWidth: 8 } }
            }
        }
    });
</script>
@endpush
