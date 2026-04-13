@extends('admin.layouts.app')

@section('title', 'Ulasan Produk')
@section('subtitle', 'Kelola dan moderasi testimoni dari pelanggan Anda')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold">Daftar Ulasan</h2>
            <p class="text-sm text-text-muted">Moderasi setiap masukan pelanggan untuk menjaga kualitas archiv</p>
        </div>
    </div>

    {{-- Stats (Optional but cool) --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="glass-card rounded-2xl p-6 flex items-center gap-4">
            <div class="w-12 h-12 bg-accent-gold/10 rounded-xl flex items-center justify-center text-accent-gold">
                <span class="material-symbols-outlined text-2xl">star</span>
            </div>
            <div>
                <p class="text-[10px] uppercase tracking-widest text-text-muted font-bold">Total Ulasan</p>
                <h4 class="text-xl font-bold">{{ $reviews->total() }} Item</h4>
            </div>
        </div>
        <div class="glass-card rounded-2xl p-6 flex items-center gap-4">
            <div class="w-12 h-12 bg-accent-emerald/10 rounded-xl flex items-center justify-center text-accent-emerald">
                <span class="material-symbols-outlined text-2xl">visibility</span>
            </div>
            <div>
                <p class="text-[10px] uppercase tracking-widest text-text-muted font-bold">Terpublikasi</p>
                <h4 class="text-xl font-bold">{{ \App\Models\ProductReview::where('is_visible', true)->count() }} Ulasan</h4>
            </div>
        </div>
        <div class="glass-card rounded-2xl p-6 flex items-center gap-4">
            <div class="w-12 h-12 bg-accent-rose/10 rounded-xl flex items-center justify-center text-accent-rose">
                <span class="material-symbols-outlined text-2xl">visibility_off</span>
            </div>
            <div>
                <p class="text-[10px] uppercase tracking-widest text-text-muted font-bold">Disembunyikan</p>
                <h4 class="text-xl font-bold">{{ \App\Models\ProductReview::where('is_visible', false)->count() }} Ulasan</h4>
            </div>
        </div>
    </div>

    {{-- Table --}}
    <div class="glass-card rounded-2xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-text-muted text-xs uppercase tracking-wider bg-admin-bg/50">
                        <th class="text-left px-6 py-4">Pelanggan</th>
                        <th class="text-left px-6 py-4">Produk</th>
                        <th class="text-left px-6 py-4">Rating & Komentar</th>
                        <th class="text-left px-6 py-4">Status</th>
                        <th class="text-left px-6 py-4">Tanggal</th>
                        <th class="text-left px-6 py-4">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-admin-border/50">
                    @forelse($reviews as $review)
                    <tr class="hover:bg-admin-card-hover/50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-accent-gold/10 flex items-center justify-center text-[10px] font-bold text-accent-gold">
                                    {{ substr($review->user->name, 0, 1) }}
                                </div>
                                <span class="font-medium text-text-primary">{{ $review->user->name }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-text-muted">{{ $review->product->nama_produk }}</span>
                        </td>
                        <td class="px-6 py-4 max-w-xs">
                            <div class="flex flex-col gap-1">
                                <div class="flex gap-0.5">
                                    @for($i = 1; $i <= 5; $i++)
                                        <span class="material-symbols-outlined text-[14px] {{ $i <= $review->rating ? 'text-accent-gold' : 'text-gray-300' }}" style="font-variation-settings: 'FILL' 1">
                                            star
                                        </span>
                                    @endfor
                                </div>
                                <p class="text-text-muted italic leading-relaxed text-xs">"{{ $review->comment }}"</p>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            @if($review->is_visible)
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-widest bg-accent-emerald/10 text-accent-emerald">Tampil</span>
                            @else
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-widest bg-gray-500/10 text-gray-500">Sembunyi</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-text-muted">
                            {{ $review->created_at->format('d M Y') }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-1">
                                <form action="{{ route('admin.reviews.toggle', $review) }}" method="POST">
                                    @csrf @method('PATCH')
                                    <button type="submit" class="p-1.5 hover:bg-admin-bg rounded-lg transition-colors" title="{{ $review->is_visible ? 'Sembunyikan' : 'Tampilkan' }}">
                                        <span class="material-symbols-outlined text-lg text-text-muted hover:text-accent-gold">
                                            {{ $review->is_visible ? 'visibility_off' : 'visibility' }}
                                        </span>
                                    </button>
                                </form>
                                <form action="{{ route('admin.reviews.destroy', $review) }}" method="POST" onsubmit="return confirm('Hapus ulasan ini secara permanen?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="p-1.5 hover:bg-admin-bg rounded-lg transition-colors" title="Hapus">
                                        <span class="material-symbols-outlined text-lg text-text-muted hover:text-red-400">delete</span>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-12 text-text-muted">
                            <span class="material-symbols-outlined text-4xl block mb-2">rate_review</span>
                            Belum ada ulasan terdaftar.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($reviews->hasPages())
        <div class="px-6 py-4 border-t border-admin-border">
            {{ $reviews->withQueryString()->links('admin.components.pagination') }}
        </div>
        @endif
    </div>
</div>
@endsection
