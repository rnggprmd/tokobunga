@extends('admin.layouts.app')
@section('title', 'Manajemen Pengiriman')
@section('subtitle', 'Kelola status pengiriman pesanan')

@section('content')
<div class="space-y-6">
    <div class="glass-card rounded-2xl p-6">
        <form method="GET" class="flex flex-wrap gap-4 items-end">
            <div class="flex-1 min-w-[200px]">
                <label class="text-xs text-text-muted mb-1 block">Cari Pengiriman</label>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Penerima, Kurir, atau Resi..."
                    class="w-full bg-admin-bg border border-admin-border rounded-xl px-4 py-2.5 text-sm text-text-primary focus:border-accent-emerald outline-none">
            </div>
            <div class="w-48">
                <label class="text-xs text-text-muted mb-1 block">Status</label>
                <select name="status" class="w-full bg-admin-bg border border-admin-border rounded-xl px-4 py-2.5 text-sm text-text-primary focus:border-accent-emerald outline-none">
                    <option value="">Semua Status</option>
                    @foreach(['pending','dikirim','sampai','dibatalkan'] as $s)
                        <option value="{{ $s }}" {{ request('status') == $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="px-6 py-2.5 bg-accent-emerald/10 text-accent-emerald rounded-xl text-sm font-medium hover:bg-accent-emerald/20 transition-colors">
                <span class="material-symbols-outlined text-lg align-middle mr-1">filter_list</span> Filter
            </button>
            @if(request()->hasAny(['search','status']))
                <a href="{{ route('admin.shipping.index') }}" class="px-4 py-2.5 text-text-muted text-sm hover:text-text-primary transition-colors">Reset</a>
            @endif
        </form>
    </div>

    <div class="glass-card rounded-2xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full min-w-max text-sm">
                <thead>
                    <tr class="text-text-muted text-xs uppercase tracking-wider bg-admin-bg/50">
                        <th class="text-left px-6 py-4">ID</th>
                        <th class="text-left px-6 py-4">Order</th>
                        <th class="text-left px-6 py-4">Penerima</th>
                        <th class="text-left px-6 py-4">Alamat</th>
                        <th class="text-left px-6 py-4">Kurir</th>
                        <th class="text-left px-6 py-4">Resi</th>
                        <th class="text-left px-6 py-4">Status</th>
                        <th class="text-left px-6 py-4">Tgl Kirim</th>
                        <th class="text-left px-6 py-4">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-admin-border/50">
                    @forelse($pengiriman as $p)
                    <tr class="hover:bg-admin-card-hover/50 transition-colors">
                        <td class="px-6 py-4 font-mono text-text-muted">#{{ $p->id }}</td>
                        <td class="px-6 py-4"><a href="{{ route('admin.orders.show', $p->order_id) }}" class="text-accent-emerald hover:underline">ORD-{{ $p->order_id }}</a></td>
                        <td class="px-6 py-4 font-medium max-w-[120px] truncate" title="{{ $p->nama_penerima }}">{{ $p->nama_penerima }}</td>
                        <td class="px-6 py-4 text-text-muted max-w-[150px] truncate" title="{{ $p->alamat_pengiriman }}">{{ $p->alamat_pengiriman }}</td>
                        <td class="px-6 py-4 max-w-[100px] truncate" title="{{ $p->kurir }}">{{ $p->kurir ?? '-' }}</td>
                        <td class="px-6 py-4 font-mono text-[10px] max-w-[100px] truncate" title="{{ $p->no_resi }}">{{ $p->no_resi ?? '-' }}</td>
                        <td class="px-6 py-4">
                            @php
                                $colors = ['pending'=>'bg-yellow-500/10 text-yellow-400','dikirim'=>'bg-blue-500/10 text-blue-400','sampai'=>'bg-emerald-500/10 text-emerald-400','dibatalkan'=>'bg-red-500/10 text-red-400'];
                            @endphp
                            <span class="px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider {{ $colors[$p->status_pengiriman] ?? '' }} whitespace-nowrap">{{ $p->status_pengiriman }}</span>
                        </td>
                        <td class="px-6 py-4 text-text-muted text-xs whitespace-nowrap">{{ $p->tanggal_kirim ?? '-' }}</td>
                        <td class="px-6 py-4">
                            <button onclick="document.getElementById('ship-modal-{{ $p->id }}').classList.toggle('hidden')" class="p-1.5 hover:bg-admin-bg rounded-lg transition-colors">
                                <span class="material-symbols-outlined text-lg text-text-muted hover:text-accent-gold">edit</span>
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="9" class="text-center py-12 text-text-muted">
                        <span class="material-symbols-outlined text-4xl block mb-2">local_shipping</span>Belum ada pengiriman
                    </td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($pengiriman->hasPages())
        <div class="px-6 py-4 border-t border-admin-border">{{ $pengiriman->withQueryString()->links('admin.components.pagination') }}</div>
        @endif
    </div>

    @foreach($pengiriman as $p)
    <div id="ship-modal-{{ $p->id }}" class="hidden fixed inset-0 bg-black/60 z-50 flex items-center justify-center" onclick="if(event.target===this)this.classList.add('hidden')">
        <div class="bg-admin-card border border-admin-border rounded-2xl p-6 w-[450px]">
            <h4 class="font-semibold mb-4 text-text-primary">Update Pengiriman #{{ $p->id }}</h4>
            <form method="POST" action="{{ route('admin.shipping.updateStatus', $p) }}">
                @csrf @method('PATCH')
                <div class="space-y-3">
                    <div>
                        <label class="text-xs text-text-muted">Status</label>
                        <select name="status_pengiriman" class="w-full bg-admin-bg border border-admin-border rounded-xl px-4 py-2.5 text-sm text-text-primary focus:border-accent-emerald outline-none">
                            @foreach(['pending','dikirim','sampai','dibatalkan'] as $s)
                                <option value="{{ $s }}" {{ $p->status_pengiriman == $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="text-xs text-text-muted">Kurir</label>
                            <input type="text" name="kurir" value="{{ $p->kurir }}" class="w-full bg-admin-bg border border-admin-border rounded-xl px-4 py-2.5 text-sm text-text-primary focus:border-accent-emerald outline-none">
                        </div>
                        <div>
                            <label class="text-xs text-text-muted">No Resi</label>
                            <input type="text" name="no_resi" value="{{ $p->no_resi }}" class="w-full bg-admin-bg border border-admin-border rounded-xl px-4 py-2.5 text-sm text-text-primary focus:border-accent-emerald outline-none">
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="text-xs text-text-muted">Tgl Kirim</label>
                            <input type="date" name="tanggal_kirim" value="{{ $p->tanggal_kirim }}" class="w-full bg-admin-bg border border-admin-border rounded-xl px-4 py-2.5 text-sm text-text-primary focus:border-accent-emerald outline-none">
                        </div>
                        <div>
                            <label class="text-xs text-text-muted">Tgl Terima</label>
                            <input type="date" name="tanggal_terima" value="{{ $p->tanggal_terima }}" class="w-full bg-admin-bg border border-admin-border rounded-xl px-4 py-2.5 text-sm text-text-primary focus:border-accent-emerald outline-none">
                        </div>
                    </div>
                </div>
                <div class="flex gap-2 mt-4">
                    <button type="submit" class="flex-1 bg-accent-emerald text-admin-bg py-2.5 rounded-xl text-sm font-semibold hover:opacity-90 transition-opacity">Simpan</button>
                    <button type="button" onclick="this.closest('[id^=ship-modal]').classList.add('hidden')" class="flex-1 bg-admin-bg border border-admin-border py-2.5 rounded-xl text-sm text-text-primary hover:bg-admin-card-hover transition-colors">Batal</button>
                </div>
            </form>
        </div>
    </div>
    @endforeach
</div>
@endsection
