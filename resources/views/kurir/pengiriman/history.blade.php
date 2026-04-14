@extends('kurir.layouts.app')
@section('title', 'Riwayat Pengiriman')
@section('subtitle', 'Daftar pengiriman yang telah Anda selesaikan')

@section('content')
<div class="space-y-6">
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
                        <th class="text-center px-6 py-5">Waktu Terima</th>
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
                            <div class="flex items-center gap-1 text-xs text-text-muted">
                                <span class="material-symbols-outlined text-sm">call</span> {{ $p->no_hp }}
                            </div>
                        </td>
                        <td class="px-6 py-5">
                            <p class="text-xs text-text-secondary leading-relaxed max-w-xs">{{ $p->alamat_pengiriman }}</p>
                        </td>
                        <td class="px-6 py-5">
                            <div class="flex flex-col gap-1 items-start">
                                <span class="px-3 py-1 border rounded-lg text-[10px] font-extrabold uppercase tracking-widest bg-accent-emerald/10 text-accent-emerald border-accent-emerald/20">
                                    {{ $p->status_pengiriman }}
                                </span>
                                <p class="text-[9px] text-text-muted italic">Dikirim: {{ $p->tanggal_kirim?->format('d M, H:i') ?? '-' }}</p>
                            </div>
                        </td>
                        <td class="px-6 py-5 text-center">
                            <div class="inline-flex flex-col items-center">
                                <p class="font-bold text-accent-emerald text-sm">{{ $p->tanggal_terima?->format('d M Y') ?? '-' }}</p>
                                <p class="text-[10px] text-text-muted">{{ $p->tanggal_terima?->format('H:i') ?? '-' }} WIB</p>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="py-20 text-center">
                            <div class="flex flex-col items-center gap-3 text-text-muted">
                                <span class="material-symbols-outlined text-5xl">history</span>
                                <p class="text-lg font-medium">Belum ada riwayat pengiriman</p>
                                <p class="text-sm">Selesaikan tugas pengantaran Anda untuk melihat riwayat di sini.</p>
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
