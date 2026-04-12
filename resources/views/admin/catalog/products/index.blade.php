@extends('admin.layouts.app')
@section('title', 'Manajemen Produk')
@section('subtitle', 'Kelola katalog produk toko')

@section('content')
<div class="space-y-6">
    <div class="flex flex-wrap items-center justify-between gap-4">
        <div class="glass-card rounded-2xl p-4 flex-1">
            <form method="GET" class="flex flex-wrap gap-4 items-end">
                <div class="flex-1 min-w-[200px]">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari produk..."
                        class="w-full bg-admin-bg border border-admin-border rounded-xl px-4 py-2.5 text-sm text-text-primary focus:border-accent-emerald outline-none">
                </div>
                <div class="w-48">
                    <select name="category_id" class="w-full bg-admin-bg border border-admin-border rounded-xl px-4 py-2.5 text-sm text-text-primary focus:border-accent-emerald outline-none">
                        <option value="">Semua Kategori</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->nama_kategori }}</option>
                        @endforeach
                    </select>
                </div>
                <button class="px-5 py-2.5 bg-accent-emerald/10 text-accent-emerald rounded-xl text-sm font-medium hover:bg-accent-emerald/20 transition-colors">
                    <span class="material-symbols-outlined text-lg align-middle">search</span>
                </button>
            </form>
        </div>
        <a href="{{ route('admin.products.create') }}" class="px-6 py-2.5 bg-accent-emerald text-admin-bg rounded-xl text-sm font-semibold hover:opacity-90 transition-opacity flex items-center gap-2">
            <span class="material-symbols-outlined text-lg">add</span> Tambah Produk
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($products as $product)
        <div class="glass-card rounded-2xl overflow-hidden stat-card group">
            <div class="h-48 bg-admin-bg relative overflow-hidden">
                @if($product->foto)
                    <img src="{{ asset('storage/'.$product->foto) }}" alt="{{ $product->nama_produk }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                @else
                    <div class="w-full h-full flex items-center justify-center">
                        <span class="material-symbols-outlined text-6xl text-admin-border">local_florist</span>
                    </div>
                @endif
                <div class="absolute top-3 right-3 px-2.5 py-1 bg-admin-bg/80 backdrop-blur rounded-full text-[10px] font-bold uppercase text-accent-emerald tracking-wider">
                    {{ $product->tipe_produk }}
                </div>
            </div>
            <div class="p-5 space-y-3">
                <div class="flex items-start justify-between gap-2">
                    <div>
                        <h3 class="font-semibold text-lg">{{ $product->nama_produk }}</h3>
                        <p class="text-xs text-text-muted">{{ $product->category->nama_kategori ?? '-' }}</p>
                    </div>
                    <p class="text-lg font-bold text-accent-gold whitespace-nowrap">Rp {{ number_format($product->harga, 0, ',', '.') }}</p>
                </div>
                <p class="text-sm text-text-muted line-clamp-2">{{ $product->deskripsi ?? 'Tidak ada deskripsi' }}</p>
                <div class="flex items-center justify-between pt-2 border-t border-admin-border/50">
                    <div class="flex gap-4 text-xs text-text-muted">
                        <span>Stok: <strong class="text-text-primary">{{ $product->stok }}</strong></span>
                        <span>Varian: <strong class="text-text-primary">{{ $product->variants->count() }}</strong></span>
                    </div>
                    <div class="flex gap-1">
                        <a href="{{ route('admin.products.edit', $product) }}" class="p-1.5 hover:bg-admin-bg rounded-lg transition-colors">
                            <span class="material-symbols-outlined text-lg text-text-muted hover:text-accent-gold">edit</span>
                        </a>
                        <form method="POST" action="{{ route('admin.products.destroy', $product) }}" onsubmit="return confirm('Hapus produk ini?')">
                            @csrf @method('DELETE')
                            <button class="p-1.5 hover:bg-admin-bg rounded-lg transition-colors">
                                <span class="material-symbols-outlined text-lg text-text-muted hover:text-red-400">delete</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-3 glass-card rounded-2xl p-12 text-center text-text-muted">
            <span class="material-symbols-outlined text-5xl block mb-3">local_florist</span>
            <p>Belum ada produk.</p>
            <a href="{{ route('admin.products.create') }}" class="text-accent-emerald hover:underline text-sm mt-2 inline-block">Tambah produk pertama →</a>
        </div>
        @endforelse
    </div>

    @if($products->hasPages())
    <div class="glass-card rounded-2xl p-4">{{ $products->withQueryString()->links('admin.components.pagination') }}</div>
    @endif
</div>
@endsection
