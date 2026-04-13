@extends('admin.layouts.app')
@section('title', 'Dashboard')
@section('subtitle', 'Ringkasan performa toko Mbah Bibit')

@section('content')
<div class="space-y-6">
    {{-- Stat Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="glass-card stat-card rounded-2xl p-5 animate-fade-in">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 bg-accent-emerald/10 rounded-xl flex items-center justify-center">
                    <span class="material-symbols-outlined text-accent-emerald text-xl">shopping_cart</span>
                </div>
                <span class="text-[10px] text-accent-emerald bg-accent-emerald/10 px-2 py-0.5 rounded-full font-bold uppercase">Total</span>
            </div>
            <p class="text-2xl font-bold">{{ number_format($totalOrders) }}</p>
            <p class="text-[10px] text-text-muted mt-1 uppercase tracking-wider">Total Orders</p>
        </div>

        <div class="glass-card stat-card rounded-2xl p-5 animate-fade-in-delay-1">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 bg-accent-gold/10 rounded-xl flex items-center justify-center">
                    <span class="material-symbols-outlined text-accent-gold text-xl">account_balance_wallet</span>
                </div>
                <span class="text-[10px] text-accent-gold bg-accent-gold/10 px-2 py-0.5 rounded-full font-bold uppercase">Revenue</span>
            </div>
            <p class="text-2xl font-bold">Rp {{ number_format($totalRevenue/1000000, 1) }}M</p>
            <p class="text-[10px] text-text-muted mt-1 uppercase tracking-wider">Total Pendapatan</p>
        </div>

        <div class="glass-card stat-card rounded-2xl p-5 animate-fade-in-delay-2">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 bg-accent-rose/10 rounded-xl flex items-center justify-center">
                    <span class="material-symbols-outlined text-accent-rose text-xl">local_florist</span>
                </div>
                <span class="text-[10px] text-accent-rose bg-accent-rose/10 px-2 py-0.5 rounded-full font-bold uppercase">Catalog</span>
            </div>
            <p class="text-2xl font-bold">{{ number_format($totalProducts) }}</p>
            <p class="text-[10px] text-text-muted mt-1 uppercase tracking-wider">Total Produk</p>
        </div>

        <div class="glass-card stat-card rounded-2xl p-5 animate-fade-in-delay-3">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 bg-blue-500/10 rounded-xl flex items-center justify-center">
                    <span class="material-symbols-outlined text-blue-400 text-xl">group</span>
                </div>
                <span class="text-[10px] text-blue-400 bg-blue-500/10 px-2 py-0.5 rounded-full font-bold uppercase">Users</span>
            </div>
            <p class="text-2xl font-bold">{{ number_format($totalUsers) }}</p>
            <p class="text-[10px] text-text-muted mt-1 uppercase tracking-wider">Total Pelanggan</p>
        </div>
    </div>

    {{-- Quick Status --}}
    <div class="grid grid-cols-2 lg:grid-cols-5 gap-3">
        <div class="glass-card rounded-xl p-3 text-center transition-all hover:bg-white/90">
            <p class="text-xl font-black text-yellow-500">{{ $pendingOrders }}</p>
            <p class="text-[8px] uppercase tracking-[0.2em] text-text-muted mt-1 font-bold">Pending</p>
        </div>
        <div class="glass-card rounded-xl p-3 text-center transition-all hover:bg-white/90">
            <p class="text-xl font-black text-blue-500">{{ $shippedOrders }}</p>
            <p class="text-[8px] uppercase tracking-[0.2em] text-text-muted mt-1 font-bold">Dikirim</p>
        </div>
        <div class="glass-card rounded-xl p-3 text-center transition-all hover:bg-white/90">
            <p class="text-xl font-black text-accent-emerald">{{ $completedOrders }}</p>
            <p class="text-[8px] uppercase tracking-[0.2em] text-text-muted mt-1 font-bold">Selesai</p>
        </div>
        <div class="glass-card rounded-xl p-3 text-center transition-all hover:bg-white/90">
            <p class="text-xl font-black text-orange-500">{{ $pendingPayments }}</p>
            <p class="text-[8px] uppercase tracking-[0.2em] text-text-muted mt-1 font-bold">Unpaid</p>
        </div>
        <div class="glass-card rounded-xl p-3 text-center transition-all hover:bg-white/90 col-span-2 lg:col-span-1">
            <p class="text-xl font-black text-purple-600">{{ $customRequests }}</p>
            <p class="text-[8px] uppercase tracking-[0.2em] text-text-muted mt-1 font-bold">Custom Request</p>
        </div>
    </div>

    {{-- Urgent Actions --}}
    @if($urgentOrdersCount > 0)
    <div class="glass-card rounded-2xl p-4 bg-accent-rose/5 border-l-4 border-accent-rose animate-fade-in">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-accent-rose/20 rounded-xl flex items-center justify-center">
                    <span class="material-symbols-outlined text-accent-rose text-xl">local_shipping</span>
                </div>
                <div>
                    <h4 class="text-sm font-bold text-text-primary">Perlu PengirimanSegera</h4>
                    <p class="text-xs text-text-muted">Ada <span class="font-bold text-accent-rose">{{ $urgentOrdersCount }} pesanan</span> yang sudah dibayar dan siap dikirim.</p>
                </div>
            </div>
            <a href="{{ route('admin.orders.index', ['status' => 'paid']) }}" class="px-4 py-2 bg-accent-rose text-white rounded-xl text-xs font-bold hover:opacity-90 transition-opacity">
                Proses Sekarang
            </a>
        </div>
    </div>
    @endif

    {{-- Row 1: Revenue & Top Products --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-stretch">
        {{-- Revenue Chart (2/3) --}}
        <div class="lg:col-span-2 glass-card rounded-3xl p-5 flex flex-col min-h-[380px]">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-sm font-bold flex items-center gap-2">
                    <span class="material-symbols-outlined text-accent-emerald text-lg">trending_up</span>
                    Revenue Bulanan
                </h3>
            </div>
            <div class="flex-1 min-h-[250px]">
                <canvas id="revenueChart"></canvas>
            </div>
        </div>

        {{-- Top Products (1/3) --}}
        <div class="lg:col-span-1 glass-card rounded-3xl p-5 flex flex-col min-h-[380px]">
            <h3 class="text-[11px] font-bold uppercase tracking-wider mb-4 flex items-center gap-2">
                <span class="material-symbols-outlined text-accent-gold text-md">star</span>
                Produk Terlaris
            </h3>
            <div class="space-y-4 flex-1">
                @foreach($topProducts as $tp)
                <div class="flex items-center gap-3">
                    <img src="{{ $tp->product->foto_produk ? asset('storage/'.$tp->product->foto_produk) : 'https://ui-avatars.com/api/?name='.urlencode($tp->product->nama_produk).'&background=FAFAE3&color=8F9E83' }}" class="w-10 h-10 rounded-xl object-cover">
                    <div class="flex-1 min-w-0">
                        <p class="text-xs font-bold truncate">{{ $tp->product->nama_produk }}</p>
                        <p class="text-[10px] text-text-muted">{{ $tp->total_qty }} Terjual</p>
                    </div>
                    <div class="h-1.5 w-12 bg-admin-bg rounded-full overflow-hidden">
                        <div class="h-full bg-accent-gold" style="width: {{ min(100, $tp->total_qty * 10) }}%"></div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Row 2: Recent Orders & Recent Customers --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        {{-- Order Baru --}}
        <div class="glass-card rounded-3xl p-5 border-t-4 border-accent-rose flex flex-col min-h-[380px]">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-[11px] font-bold uppercase tracking-wider flex items-center gap-2">
                    <span class="material-symbols-outlined text-accent-rose text-md">history</span>
                    Order Baru
                </h3>
                <a href="{{ route('admin.orders.index') }}" class="text-[9px] font-bold text-accent-emerald hover:underline">Semua</a>
            </div>
            <div class="space-y-3 flex-1 overflow-y-auto pr-1">
                @forelse($recentOrders as $order)
                <a href="{{ route('admin.orders.show', $order) }}" class="block p-3 rounded-2xl hover:bg-admin-card-hover/40 transition-all border border-transparent hover:border-admin-border group">
                    <div class="flex items-center justify-between mb-1">
                        <span class="text-[8px] font-mono text-text-muted">#{{ $order->id }}</span>
                        <span class="text-[9px] font-bold text-accent-gold">Rp {{ number_format($order->total_harga / 1000, 1) }}k</span>
                    </div>
                    <p class="text-xs font-bold truncate">{{ $order->customer_name ?? ($order->user->name ?? '-') }}</p>
                    <div class="flex justify-between items-center mt-1">
                        <span class="text-[10px] text-text-muted">{{ $order->created_at->diffForHumans() }}</span>
                        @php $colors = ['pending'=>'text-yellow-500','paid'=>'text-blue-500','shipped'=>'text-purple-500','completed'=>'text-emerald-500','cancelled'=>'text-red-500']; @endphp
                        <span class="text-[8px] uppercase font-black {{ $colors[$order->status] ?? 'text-gray-400' }}">{{ $order->status }}</span>
                    </div>
                </a>
                @empty
                <p class="text-center py-10 text-xs text-text-muted italic">Tidak ada order baru</p>
                @endforelse
            </div>
        </div>

        {{-- Customer Baru --}}
        <div class="glass-card rounded-3xl p-5 border-t-4 border-accent-emerald flex flex-col min-h-[380px]">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-[11px] font-bold uppercase tracking-wider flex items-center gap-2">
                    <span class="material-symbols-outlined text-accent-emerald text-md">person_add</span>
                    Customer Baru
                </h3>
                <a href="{{ route('admin.users.index') }}" class="text-[9px] font-bold text-accent-emerald hover:underline">Kelola</a>
            </div>
            <div class="space-y-4 flex-1">
                @foreach($recentUsers as $user)
                <div class="flex items-center gap-4 p-2 rounded-2xl hover:bg-admin-bg transition-colors">
                    <div class="w-10 h-10 rounded-full bg-accent-emerald/10 flex items-center justify-center text-accent-emerald font-bold">
                        {{ substr($user->name, 0, 1) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-xs font-bold truncate">{{ $user->name }}</p>
                        <p class="text-[10px] text-text-muted">{{ $user->email }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-[9px] text-text-muted">{{ $user->created_at->format('d M') }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Row 3: Categories & Stock --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Top Categories --}}
        <div class="lg:col-span-1 glass-card rounded-3xl p-5">
            <h3 class="text-[11px] font-bold uppercase tracking-wider mb-4 flex items-center gap-2">
                <span class="material-symbols-outlined text-accent-emerald text-md">category</span>
                Kategori Terlaris
            </h3>
            <div class="h-48">
                <canvas id="categoryChart"></canvas>
            </div>
        </div>

        {{-- Low Stock Alert --}}
        <div class="lg:col-span-2 glass-card rounded-3xl p-5 border-l-4 border-red-500 bg-red-500/[0.02]">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-xs font-black flex items-center gap-2 text-red-600 uppercase tracking-widest">
                    <span class="material-symbols-outlined text-red-500 text-lg">warning</span>
                    Produk Hampir Habis
                </h3>
                <span class="text-[10px] bg-red-500 text-white px-2 py-0.5 rounded-lg font-black uppercase">{{ $lowStockProducts->count() }} Item</span>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                @foreach($lowStockProducts->take(6) as $lp)
                    <a href="{{ route('admin.products.edit', $lp) }}" class="flex items-center gap-3 p-3 bg-white rounded-2xl border border-admin-border hover:border-red-500/30 transition-all group">
                        <img src="{{ $lp->foto_produk ? asset('storage/'.$lp->foto_produk) : 'https://ui-avatars.com/api/?name='.urlencode($lp->nama_produk).'&background=fee2e2&color=ef4444' }}" class="w-10 h-10 rounded-xl object-cover">
                        <div class="flex-1 min-w-0">
                            <p class="text-[10px] font-bold truncate group-hover:text-red-600 transition-colors uppercase">{{ $lp->nama_produk }}</p>
                            <div class="flex items-center gap-2 mt-1">
                                <div class="flex-1 h-1 bg-gray-100 rounded-full overflow-hidden">
                                    <div class="h-full bg-red-500" style="width: {{ ($lp->stok / 5) * 100 }}%"></div>
                                </div>
                                <span class="text-[9px] text-red-600 font-bold">{{ $lp->stok }}</span>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    Chart.defaults.font.family = "'Inter', sans-serif";
    Chart.defaults.color = '#7A7F75';

    // Revenue Chart
    const revenueCtx = document.getElementById('revenueChart').getContext('2d');
    const gradient = revenueCtx.createLinearGradient(0, 0, 0, 300);
    gradient.addColorStop(0, 'rgba(143, 158, 131, 0.4)');
    gradient.addColorStop(1, 'rgba(143, 158, 131, 0.01)');

    new Chart(revenueCtx, {
        type: 'line',
        data: {
            labels: {!! json_encode($monthlyRevenue->pluck('month')) !!},
            datasets: [{
                label: 'Net Revenue',
                data: {!! json_encode($monthlyRevenue->pluck('total')) !!},
                borderColor: '#8F9E83',
                backgroundColor: gradient,
                borderWidth: 2,
                fill: true,
                tension: 0.4,
                pointBackgroundColor: '#FAFAE3',
                pointBorderColor: '#8F9E83',
                pointBorderWidth: 2,
                pointRadius: 3,
                pointHoverRadius: 5,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    padding: 8,
                    backgroundColor: '#2C2E2A',
                    titleFont: { size: 9 },
                    bodyFont: { size: 11 },
                    callbacks: { label: (ctx) => 'Rp ' + Number(ctx.raw).toLocaleString('id-ID') }
                }
            },
            scales: {
                x: { grid: { display: false }, ticks: { font: { size: 9 } } },
                y: { 
                    grid: { color: 'rgba(217, 217, 195, 0.2)', borderDash: [5, 5] }, 
                    ticks: { font: { size: 9 }, callback: v => 'Rp ' + (v/1000) + 'k' } 
                }
            }
        }
    });

    // Category Doughnut
    const categoryCtx = document.getElementById('categoryChart').getContext('2d');
    new Chart(categoryCtx, {
        type: 'doughnut',
        data: {
            labels: {!! json_encode($topCategories->pluck('nama_kategori')) !!},
            datasets: [{
                data: {!! json_encode($topCategories->pluck('total_qty')) !!},
                backgroundColor: ['#8F9E83', '#D9C5A9', '#D9B2A9', '#A5A68F', '#EBD6D1'],
                borderWidth: 4,
                borderColor: '#FFFFFF',
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '70%',
            plugins: {
                legend: { 
                    position: 'bottom', 
                    labels: { 
                        padding: 15, 
                        usePointStyle: true, 
                        font: { size: 9, weight: 'bold' }
                    } 
                }
            }
        }
    });
</script>
@endpush
