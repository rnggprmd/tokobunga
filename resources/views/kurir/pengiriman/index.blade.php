@extends('kurir.layouts.app')
@section('title', 'Tugas Pengiriman')
@section('subtitle', 'Daftar pengiriman yang sedang aktif')

@section('content')
<div class="space-y-6">
    {{-- Search & Filter --}}
    <div class="glass-card rounded-3xl p-6 border border-admin-border/50">
        <form method="GET" class="flex flex-wrap gap-4 items-end">
            <div class="flex-1 min-w-[240px]">
                <label class="text-[10px] uppercase font-bold text-text-muted tracking-widest mb-2 block">Status Pengiriman</label>
                <select name="status" class="w-full bg-admin-bg border border-admin-border rounded-2xl px-5 py-3 text-sm focus:border-accent-emerald outline-none appearance-none cursor-pointer transition-all">
                    <option value="">Semua Status</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Tertunda (Pending)</option>
                    <option value="dikirim" {{ request('status') == 'dikirim' ? 'selected' : '' }}>Sedang Dikirim (Proses)</option>
                    <option value="sampai" {{ request('status') == 'sampai' ? 'selected' : '' }}>Selesai (Sampai)</option>
                </select>
            </div>
            <button type="submit" class="px-8 py-3 bg-admin-surface text-white rounded-2xl text-sm font-bold shadow-lg shadow-admin-surface/20 hover:opacity-90 transition-all flex items-center gap-2">
                <span class="material-symbols-outlined text-lg">filter_alt</span> Filter
            </button>
            @if(request()->filled('status'))
                <a href="{{ route('kurir.pengiriman.index') }}" class="px-6 py-3 bg-white border border-admin-border rounded-2xl text-sm font-semibold hover:bg-admin-bg transition-all">Reset</a>
            @endif
        </form>
    </div>

    {{-- Shipping Table --}}
    <div class="glass-card rounded-3xl overflow-hidden border border-admin-border/50">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-text-muted text-[10px] uppercase font-bold tracking-[0.1em] bg-admin-bg/50">
                        <th class="text-left px-6 py-5">Info Pesanan</th>
                        <th class="text-left px-6 py-5">Penerima & Kontak</th>
                        <th class="text-left px-6 py-5">Alamat Lengkap</th>
                        <th class="text-left px-6 py-5">Status</th>
                        <th class="text-center px-6 py-5">Tindakan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-admin-border/30">
                    @forelse($pengirimanList as $p)
                    <tr class="hover:bg-admin-card-hover/20 transition-colors group">
                        <td class="px-6 py-5">
                            <p class="font-bold text-lg text-text-primary">#{{ $p->order->id }}</p>
                            <p class="text-xs text-text-muted mb-1">{{ $p->created_at->format('d M Y, H:i') }}</p>
                            <span class="text-[10px] px-2 py-0.5 bg-admin-surface/10 text-admin-surface rounded-full font-bold uppercase tracking-widest">{{ $p->kurir }}</span>
                        </td>
                        <td class="px-6 py-5">
                            <p class="font-bold text-text-primary text-base">{{ $p->nama_penerima }}</p>
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $p->no_hp) }}" target="_blank" class="flex items-center gap-1 text-xs text-accent-emerald font-bold hover:underline">
                                <span class="material-symbols-outlined text-sm">call</span> {{ $p->no_hp }}
                            </a>
                        </td>
                        <td class="px-6 py-5">
                            <p class="text-xs text-text-secondary leading-relaxed max-w-xs">{{ $p->alamat_pengiriman }}</p>
                        </td>
                        <td class="px-6 py-5">
                            @php
                                $statusStyles = [
                                    'pending' => 'bg-accent-gold/10 text-accent-gold border-accent-gold/20',
                                    'dikirim' => 'bg-blue-500/10 text-blue-500 border-blue-500/20',
                                    'sampai' => 'bg-accent-emerald/10 text-accent-emerald border-accent-emerald/20',
                                ];
                                $currentStyle = $statusStyles[$p->status_pengiriman] ?? 'bg-admin-surface/10 text-admin-surface border-admin-surface/20';
                            @endphp
                            <div class="flex flex-col gap-1 items-start">
                                <span class="px-3 py-1 border rounded-lg text-[10px] font-extrabold uppercase tracking-widest {{ $currentStyle }}">
                                    {{ $p->status_pengiriman }}
                                </span>
                                @if($p->status_pengiriman == 'sampai')
                                    <p class="text-[9px] text-text-muted italic">Diterima: {{ optional($p->tanggal_terima)->format('d M, H:i') ?? '—' }}</p>
                                @elseif($p->status_pengiriman == 'dikirim')
                                    <p class="text-[9px] text-text-muted italic">Dikirim: {{ optional($p->tanggal_kirim)->format('d M, H:i') ?? '—' }}</p>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-5">
                            <div class="flex justify-center">
                                @if($p->status_pengiriman == 'pending')
                                    <form action="{{ route('kurir.pengiriman.proses', $p) }}" method="POST">
                                        @csrf @method('PATCH')
                                        <button class="px-6 py-2 bg-blue-500 text-white rounded-xl text-xs font-bold hover:shadow-lg hover:shadow-blue-500/30 transition-all flex items-center gap-2">
                                            <span class="material-symbols-outlined text-lg">local_shipping</span> Mulai Antar
                                        </button>
                                    </form>
                                @elseif($p->status_pengiriman == 'dikirim')
                                    <form action="{{ route('kurir.pengiriman.selesai', $p) }}" method="POST">
                                        @csrf @method('PATCH')
                                        <button class="px-6 py-2 bg-accent-emerald text-white rounded-xl text-xs font-bold hover:shadow-lg hover:shadow-accent-emerald/30 transition-all flex items-center gap-2">
                                            <span class="material-symbols-outlined text-lg">verified</span> Selesai
                                        </button>
                                    </form>
                                @else
                                    <div class="flex items-center gap-2 text-accent-emerald font-bold text-xs">
                                        <span class="material-symbols-outlined">check_circle</span> TERKIRIM
                                    </div>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="py-20 text-center">
                            <div class="flex flex-col items-center gap-3 text-text-muted">
                                <span class="material-symbols-outlined text-5xl">inventory_2</span>
                                <p class="text-lg font-medium">Tidak ada pengiriman ditemukan</p>
                                <p class="text-sm">Silakan pilih filter lain atau hubungi admin.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($pengirimanList->hasPages())
        <div class="px-6 py-6 border-t border-admin-border/50 bg-admin-bg/30">
            {{ $pengirimanList->links('admin.components.pagination') }}
        </div>
        @endif
    </div>
</div>
@endsection
