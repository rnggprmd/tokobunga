@extends('admin.layouts.app')
@section('title', 'Manajemen Pembayaran')
@section('subtitle', 'Kelola status pembayaran pelanggan')

@section('content')
<div class="space-y-6">
    <div class="glass-card rounded-2xl p-6">
        <form method="GET" class="flex flex-wrap gap-4 items-end">
            <div class="flex-1 min-w-[200px]">
                <label class="text-xs text-text-muted mb-1 block">Cari Pembayaran</label>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Customer, Order ID, atau Metode..."
                    class="w-full bg-admin-bg border border-admin-border rounded-xl px-4 py-2.5 text-sm text-text-primary focus:border-accent-emerald outline-none">
            </div>
            <div class="w-48">
                <label class="text-xs text-text-muted mb-1 block">Status</label>
                <select name="status" class="w-full bg-admin-bg border border-admin-border rounded-xl px-4 py-2.5 text-sm text-text-primary focus:border-accent-emerald outline-none">
                    <option value="">Semua Status</option>
                    @foreach(['pending','paid','failed','refund'] as $s)
                        <option value="{{ $s }}" {{ request('status') == $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="px-6 py-2.5 bg-accent-emerald/10 text-accent-emerald rounded-xl text-sm font-medium hover:bg-accent-emerald/20 transition-colors">
                <span class="material-symbols-outlined text-lg align-middle mr-1">filter_list</span> Filter
            </button>
            @if(request()->hasAny(['search','status']))
                <a href="{{ route('admin.payments.index') }}" class="px-4 py-2.5 text-text-muted text-sm hover:text-text-primary transition-colors">Reset</a>
            @endif
        </form>
    </div>

    <div class="glass-card rounded-2xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-text-muted text-xs uppercase tracking-wider bg-admin-bg/50">
                        <th class="text-left px-6 py-4">ID</th>
                        <th class="text-left px-6 py-4">Order</th>
                        <th class="text-left px-6 py-4">Customer</th>
                        <th class="text-left px-6 py-4">Metode</th>
                        <th class="text-left px-6 py-4">Jumlah</th>
                        <th class="text-left px-6 py-4">Status</th>
                        <th class="text-left px-6 py-4">Tgl Bayar</th>
                        <th class="text-left px-6 py-4">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-admin-border/50">
                    @forelse($pembayaran as $p)
                    <tr class="hover:bg-admin-card-hover/50 transition-colors">
                        <td class="px-6 py-4 font-mono text-text-muted">#{{ $p->id }}</td>
                        <td class="px-6 py-4"><a href="{{ route('admin.orders.show', $p->order_id) }}" class="text-accent-emerald hover:underline">ORD-{{ $p->order_id }}</a></td>
                        <td class="px-6 py-4">{{ $p->order->customer_name ?? ($p->order->user->name ?? '-') }}</td>
                        <td class="px-6 py-4">{{ ucfirst($p->metode_pembayaran) }}</td>
                        <td class="px-6 py-4 font-medium text-accent-gold">Rp {{ number_format($p->jumlah_bayar, 0, ',', '.') }}</td>
                        <td class="px-6 py-4">
                            @php
                                $colors = ['pending'=>'bg-yellow-500/10 text-yellow-400','paid'=>'bg-emerald-500/10 text-emerald-400'];
                            @endphp
                            <span class="px-2.5 py-1 rounded-full text-xs font-medium {{ $colors[$p->status_pembayaran] ?? '' }}">{{ ucfirst($p->status_pembayaran) }}</span>
                        </td>
                        <td class="px-6 py-4 text-text-muted">{{ $p->tanggal_bayar ? $p->tanggal_bayar->format('d M Y H:i') : '-' }}</td>
                        <td class="px-6 py-4">
                            <button onclick="document.getElementById('pay-modal-{{ $p->id }}').classList.toggle('hidden')" class="p-1.5 hover:bg-admin-bg rounded-lg transition-colors">
                                <span class="material-symbols-outlined text-lg text-text-muted hover:text-accent-gold">edit</span>
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="8" class="text-center py-12 text-text-muted">
                        <span class="material-symbols-outlined text-4xl block mb-2">payments</span>Belum ada pembayaran
                    </td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($pembayaran->hasPages())
        <div class="px-6 py-4 border-t border-admin-border">{{ $pembayaran->withQueryString()->links('admin.components.pagination') }}</div>
        @endif
    </div>

    @foreach($pembayaran as $p)
    <div id="pay-modal-{{ $p->id }}" class="hidden fixed inset-0 bg-black/60 z-50 flex items-center justify-center" onclick="if(event.target===this)this.classList.add('hidden')">
        <div class="bg-admin-card border border-admin-border rounded-2xl p-6 w-96">
            <h4 class="font-semibold mb-4 text-text-primary">Update Status Pembayaran #{{ $p->id }}</h4>
            <form method="POST" action="{{ route('admin.payments.updateStatus', $p) }}">
                @csrf @method('PATCH')
                <select name="status_pembayaran" class="w-full bg-admin-bg border border-admin-border rounded-xl px-4 py-2.5 text-sm mb-4 text-text-primary focus:border-accent-emerald outline-none">
                    @foreach(['pending','paid'] as $s)
                        <option value="{{ $s }}" {{ $p->status_pembayaran == $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                    @endforeach
                </select>
                <div class="flex gap-2">
                    <button type="submit" class="flex-1 bg-accent-emerald text-admin-bg py-2.5 rounded-xl text-sm font-semibold hover:opacity-90 transition-opacity">Simpan</button>
                    <button type="button" onclick="this.closest('[id^=pay-modal]').classList.add('hidden')" class="flex-1 bg-admin-bg border border-admin-border py-2.5 rounded-xl text-sm text-text-primary hover:bg-admin-card-hover transition-colors">Batal</button>
                </div>
            </form>
        </div>
    </div>
    @endforeach
</div>
@endsection
