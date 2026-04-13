@extends('admin.layouts.app')
@section('title', 'Manajemen Order')
@section('subtitle', 'Kelola semua pesanan pelanggan')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold">Daftar Order</h2>
            <p class="text-sm text-text-muted">Kelola semua pesanan pelanggan</p>
        </div>
        <a href="{{ route('admin.orders.create') }}" class="px-5 py-2.5 bg-accent-emerald text-admin-bg rounded-xl text-sm font-bold flex items-center gap-2 hover:opacity-90 transition-opacity">
            <span class="material-symbols-outlined">add_shopping_cart</span> Tambah Order Manual
        </a>
    </div>

    {{-- Filters --}}
    <div class="glass-card rounded-2xl p-6">
        <form method="GET" class="flex flex-wrap gap-4 items-end">
            <div class="flex-1 min-w-[200px]">
                <label class="text-xs text-text-muted mb-1 block">Cari Order</label>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Nama customer atau ID order..."
                    class="w-full bg-admin-bg border border-admin-border rounded-xl px-4 py-2.5 text-sm text-text-primary focus:border-accent-emerald focus:ring-1 focus:ring-accent-emerald outline-none transition-colors">
            </div>
            <div class="w-48">
                <label class="text-xs text-text-muted mb-1 block">Status</label>
                <select name="status" class="w-full bg-admin-bg border border-admin-border rounded-xl px-4 py-2.5 text-sm text-text-primary focus:border-accent-emerald outline-none">
                    <option value="">Semua Status</option>
                    @foreach(['pending' => 'Pending', 'paid' => 'Sudah Bayar', 'shipped' => 'Dikirim', 'completed' => 'Selesai', 'cancelled' => 'Dibatalkan'] as $val => $label)
                        <option value="{{ $val }}" {{ request('status') == $val ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="px-6 py-2.5 bg-accent-emerald/10 text-accent-emerald rounded-xl text-sm font-medium hover:bg-accent-emerald/20 transition-colors">
                <span class="material-symbols-outlined text-lg align-middle mr-1">filter_list</span> Filter
            </button>
            @if(request()->hasAny(['search','status']))
                <a href="{{ route('admin.orders.index') }}" class="px-4 py-2.5 text-text-muted text-sm hover:text-text-primary transition-colors">Reset</a>
            @endif
        </form>
    </div>

    {{-- Table --}}
    <div class="glass-card rounded-2xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full min-w-max text-sm">
                <thead>
                    <tr class="text-text-muted text-xs uppercase tracking-wider bg-admin-bg/50">
                        <th class="text-left px-6 py-4">ID</th>
                        <th class="text-left px-6 py-4">Customer</th>
                        <th class="text-left px-6 py-4">Email</th>
                        <th class="text-left px-6 py-4">Total</th>
                        <th class="text-left px-6 py-4">Status</th>
                        <th class="text-left px-6 py-4">Pembayaran</th>
                        <th class="text-left px-6 py-4">Tanggal</th>
                        <th class="text-left px-6 py-4">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-admin-border/50">
                    @forelse($orders as $order)
                    <tr class="hover:bg-admin-card-hover/50 transition-colors">
                        <td class="px-6 py-4 font-mono text-text-muted">#{{ $order->id }}</td>
                        <td class="px-6 py-4 font-medium max-w-[150px] truncate" title="{{ $order->customer_name }}">{{ $order->customer_name ?? '-' }}</td>
                        <td class="px-6 py-4 text-text-muted max-w-[150px] truncate" title="{{ $order->customer_email }}">{{ $order->customer_email ?? '-' }}</td>
                        <td class="px-6 py-4 font-medium text-accent-gold whitespace-nowrap">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</td>
                        <td class="px-6 py-4">
                            @php
                                $statusLabels = ['pending' => 'Pending', 'paid' => 'Sudah Bayar', 'shipped' => 'Dikirim', 'completed' => 'Selesai', 'cancelled' => 'Dibatalkan'];
                                $colors = ['pending'=>'bg-yellow-500/10 text-yellow-400','paid'=>'bg-blue-500/10 text-blue-400','shipped'=>'bg-purple-500/10 text-purple-400','completed'=>'bg-emerald-500/10 text-emerald-400','cancelled'=>'bg-red-500/10 text-red-400'];
                                $color = $colors[$order->status] ?? 'bg-gray-500/10 text-gray-400';
                                $label = $statusLabels[$order->status] ?? ucfirst($order->status);
                            @endphp
                            <span class="px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider {{ $color }} whitespace-nowrap">{{ $label }}</span>
                        </td>
                        <td class="px-6 py-4 text-xs text-text-muted whitespace-nowrap">{{ $order->metode_pembayaran ?? '-' }}</td>
                        <td class="px-6 py-4 text-text-muted whitespace-nowrap text-xs">{{ $order->created_at->format('d M Y') }}</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-1">
                                <a href="{{ route('admin.orders.show', $order) }}" class="p-1.5 hover:bg-admin-bg rounded-lg transition-colors" title="Detail">
                                    <span class="material-symbols-outlined text-lg text-text-muted hover:text-accent-emerald">visibility</span>
                                </a>
                                <button onclick="document.getElementById('status-modal-{{ $order->id }}').classList.toggle('hidden')" class="p-1.5 hover:bg-admin-bg rounded-lg transition-colors" title="Update Status">
                                    <span class="material-symbols-outlined text-lg text-text-muted hover:text-accent-gold">edit</span>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="8" class="text-center py-12 text-text-muted">
                        <span class="material-symbols-outlined text-4xl block mb-2">inbox</span>Belum ada order
                    </td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($orders->hasPages())
        <div class="px-6 py-4 border-t border-admin-border">
            {{ $orders->withQueryString()->links('admin.components.pagination') }}
        </div>
        @endif
    </div>

    @foreach($orders as $order)
    <div id="status-modal-{{ $order->id }}" class="hidden fixed inset-0 bg-black/60 z-50 flex items-center justify-center" onclick="if(event.target===this)this.classList.add('hidden')">
        <div class="bg-admin-card border border-admin-border rounded-2xl p-6 w-96">
            <h4 class="font-semibold mb-4 text-text-primary">Update Status Order #{{ $order->id }}</h4>
            <form method="POST" action="{{ route('admin.orders.updateStatus', $order) }}">
                @csrf @method('PATCH')
                <select name="status" class="w-full bg-admin-bg border border-admin-border rounded-xl px-4 py-2.5 text-sm mb-4 text-text-primary outline-none focus:border-accent-emerald">
                    @foreach(['pending' => 'Pending', 'paid' => 'Sudah Bayar', 'shipped' => 'Dikirim', 'completed' => 'Selesai', 'cancelled' => 'Dibatalkan'] as $val => $label)
                        <option value="{{ $val }}" {{ $order->status == $val ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                <div class="flex gap-2">
                    <button type="submit" class="flex-1 bg-accent-emerald text-admin-bg py-2.5 rounded-xl text-sm font-semibold hover:opacity-90 transition-opacity">Simpan</button>
                    <button type="button" onclick="this.closest('[id^=status-modal]').classList.add('hidden')" class="flex-1 bg-admin-bg border border-admin-border py-2.5 rounded-xl text-sm text-text-primary hover:bg-admin-card-hover transition-colors">Batal</button>
                </div>
            </form>
        </div>
    </div>
    @endforeach
</div>
@endsection
