@extends('kurir.layouts.app')
@section('title', 'Dashboard Kurir')

@section('content')
<div class="space-y-6">
    {{-- Stats Grid --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 px-2">
        <div class="glass-card p-6 rounded-3xl relative overflow-hidden group hover:bg-white transition-all duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold text-text-muted uppercase tracking-widest mb-1">Total Tugas</p>
                    <h3 class="text-3xl font-bold text-text-primary">{{ $totalTugas }}</h3>
                </div>
                <div class="w-12 h-12 bg-admin-surface/10 rounded-2xl flex items-center justify-center text-admin-surface">
                    <span class="material-symbols-outlined text-2xl">local_shipping</span>
                </div>
            </div>
        </div>

        <div class="glass-card p-6 rounded-3xl relative overflow-hidden group hover:bg-white transition-all duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold text-text-muted uppercase tracking-widest mb-1">Menunggu</p>
                    <h3 class="text-3xl font-bold text-text-primary">{{ $menunggu }}</h3>
                </div>
                <div class="w-12 h-12 bg-accent-gold/10 rounded-2xl flex items-center justify-center text-accent-gold">
                    <span class="material-symbols-outlined text-2xl">pending_actions</span>
                </div>
            </div>
        </div>

        <div class="glass-card p-6 rounded-3xl relative overflow-hidden group hover:bg-white transition-all duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold text-text-muted uppercase tracking-widest mb-1">Sedang Diantar</p>
                    <h3 class="text-3xl font-bold text-text-primary">{{ $sedangDiantar }}</h3>
                </div>
                <div class="w-12 h-12 bg-blue-500/10 rounded-2xl flex items-center justify-center text-blue-500">
                    <span class="material-symbols-outlined text-2xl">forklift</span>
                </div>
            </div>
        </div>

        <div class="glass-card p-6 rounded-3xl relative overflow-hidden group hover:bg-white transition-all duration-300 text-accent-emerald">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold text-text-muted uppercase tracking-widest mb-1">Selesai</p>
                    <h3 class="text-3xl font-bold">{{ $selesai }}</h3>
                </div>
                <div class="w-12 h-12 bg-accent-emerald/10 rounded-2xl flex items-center justify-center">
                    <span class="material-symbols-outlined text-2xl">check_circle</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Recent Assignments Table --}}
    <div class="p-2">
        <div class="glass-card rounded-3xl overflow-hidden border border-admin-border/50">
            <div class="px-6 py-5 border-b border-admin-border/50 bg-white/50 flex items-center justify-between">
                <h3 class="font-bold text-text-primary flex items-center gap-2">
                    <span class="material-symbols-outlined text-accent-emerald">assignment</span> Penugasan Terbaru
                </h3>
                <a href="{{ route('kurir.pengiriman.index') }}" class="text-xs font-bold text-accent-emerald uppercase tracking-widest hover:underline">Lihat Semua</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="text-text-muted text-[10px] uppercase font-bold tracking-[0.1em] bg-admin-bg/50">
                            <th class="text-left px-6 py-4">Pesanan</th>
                            <th class="text-left px-6 py-4">Penerima</th>
                            <th class="text-left px-6 py-4">Alamat</th>
                            <th class="text-left px-6 py-4">Status</th>
                            <th class="text-center px-6 py-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-admin-border/30">
                        @forelse($recentPengiriman as $p)
                        <tr class="hover:bg-admin-card-hover/20 transition-colors">
                            <td class="px-6 py-4">
                                <p class="font-bold text-text-primary">#{{ $p->order->id }}</p>
                                <p class="text-[10px] text-text-muted">{{ $p->created_at->format('d M, H:i') }}</p>
                            </td>
                            <td class="px-6 py-4">
                                <p class="font-semibold">{{ $p->nama_penerima }}</p>
                                <p class="text-xs text-text-muted">{{ $p->no_hp }}</p>
                            </td>
                            <td class="px-6 py-4 max-w-xs transition-all">
                                <p class="truncate hover:whitespace-normal text-xs">{{ $p->alamat_pengiriman }}</p>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 rounded-lg text-[10px] font-bold uppercase tracking-wider
                                    {{ $p->status_pengiriman == 'sampai' ? 'bg-accent-emerald/10 text-accent-emerald' : ($p->status_pengiriman == 'dikirim' ? 'bg-blue-500/10 text-blue-500' : 'bg-accent-gold/10 text-accent-gold') }}">
                                    {{ $p->status_pengiriman }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if($p->status_pengiriman == 'pending')
                                    <form action="{{ route('kurir.pengiriman.proses', $p) }}" method="POST">
                                        @csrf @method('PATCH')
                                        <button class="px-3 py-1.5 bg-blue-500 text-white rounded-lg text-xs font-bold hover:opacity-90">Ambil</button>
                                    </form>
                                @elseif($p->status_pengiriman == 'dikirim')
                                    <form action="{{ route('kurir.pengiriman.selesai', $p) }}" method="POST">
                                        @csrf @method('PATCH')
                                        <button class="px-3 py-1.5 bg-accent-emerald text-white rounded-lg text-xs font-bold hover:opacity-90">Selesai</button>
                                    </form>
                                @else
                                    <span class="text-text-muted">✓</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="5" class="py-12 text-center text-text-muted italic">Tidak ada penugasan baru</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
