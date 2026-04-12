@extends('admin.layouts.app')
@section('title', 'Varian Produk')
@section('subtitle', 'Kelola varian ukuran dan harga produk')

@section('content')
<div class="space-y-6">
    {{-- Add Variant Form --}}
    <div class="glass-card rounded-2xl p-6">
        <h3 class="font-semibold mb-4 flex items-center gap-2">
            <span class="material-symbols-outlined text-accent-emerald">add_circle</span> Tambah Varian Baru
        </h3>
        <form method="POST" action="{{ route('admin.variants.store') }}" class="flex flex-wrap gap-4 items-end">
            @csrf
            <div class="w-56">
                <label class="text-xs text-text-muted mb-1 block">Produk</label>
                <select name="product_id" required class="w-full bg-admin-bg border border-admin-border rounded-xl px-4 py-2.5 text-sm text-text-primary focus:border-accent-emerald outline-none">
                    <option value="">Pilih Produk</option>
                    @foreach($products as $p)
                        <option value="{{ $p->id }}">{{ $p->nama_produk }}</option>
                    @endforeach
                </select>
            </div>
            <div class="w-32">
                <label class="text-xs text-text-muted mb-1 block">Ukuran/Varian</label>
                <input type="text" name="size" required placeholder="S, M, L, 1kg..."
                    class="w-full bg-admin-bg border border-admin-border rounded-xl px-4 py-2.5 text-sm text-text-primary focus:border-accent-emerald outline-none">
            </div>
            <div class="w-28">
                <label class="text-xs text-text-muted mb-1 block">Stok</label>
                <input type="number" name="stock" required min="0" value="0"
                    class="w-full bg-admin-bg border border-admin-border rounded-xl px-4 py-2.5 text-sm text-text-primary focus:border-accent-emerald outline-none">
            </div>
            <div class="w-36">
                <label class="text-xs text-text-muted mb-1 block">Harga (Rp)</label>
                <input type="number" name="price_adjustment" required min="0" value="0" step="100"
                    class="w-full bg-admin-bg border border-admin-border rounded-xl px-4 py-2.5 text-sm text-text-primary focus:border-accent-emerald outline-none">
            </div>
            <button class="px-6 py-2.5 bg-accent-emerald text-admin-bg rounded-xl text-sm font-semibold hover:opacity-90 transition-opacity">
                <span class="material-symbols-outlined text-lg align-middle mr-1">add</span> Tambah
            </button>
        </form>
    </div>

    {{-- Filter --}}
    <div class="glass-card rounded-2xl p-4">
        <form method="GET" class="flex flex-wrap gap-4 items-end">
            <div class="w-56">
                <select name="product_id" class="w-full bg-admin-bg border border-admin-border rounded-xl px-4 py-2.5 text-sm text-text-primary focus:border-accent-emerald outline-none">
                    <option value="">Semua Produk</option>
                    @foreach($products as $p)
                        <option value="{{ $p->id }}" {{ request('product_id') == $p->id ? 'selected' : '' }}>{{ $p->nama_produk }}</option>
                    @endforeach
                </select>
            </div>
            <button class="px-5 py-2.5 bg-accent-emerald/10 text-accent-emerald rounded-xl text-sm font-medium hover:bg-accent-emerald/20 transition-colors">Filter</button>
            @if(request('product_id'))<a href="{{ route('admin.variants.index') }}" class="px-4 py-2.5 text-text-muted text-sm">Reset</a>@endif
        </form>
    </div>

    {{-- Table --}}
    <div class="glass-card rounded-2xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-text-muted text-xs uppercase tracking-wider bg-admin-bg/50">
                        <th class="text-left px-6 py-4">ID</th>
                        <th class="text-left px-6 py-4">Produk</th>
                        <th class="text-left px-6 py-4">Kategori</th>
                        <th class="text-left px-6 py-4">Ukuran</th>
                        <th class="text-left px-6 py-4">Stok</th>
                        <th class="text-left px-6 py-4">Harga</th>
                        <th class="text-left px-6 py-4">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-admin-border/50">
                    @forelse($variants as $v)
                    <tr class="hover:bg-admin-card-hover/50 transition-colors">
                        <td class="px-6 py-4 font-mono text-text-muted">#{{ $v->id }}</td>
                        <td class="px-6 py-4 font-medium">{{ $v->product->nama_produk ?? '-' }}</td>
                        <td class="px-6 py-4 text-text-muted">{{ $v->product->category->nama_kategori ?? '-' }}</td>
                        <td class="px-6 py-4">
                            <span class="px-2.5 py-1 bg-admin-bg rounded-lg text-xs font-medium">{{ $v->size }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="{{ $v->stock > 0 ? 'text-accent-emerald' : 'text-red-400' }}">{{ $v->stock }}</span>
                        </td>
                        <td class="px-6 py-4 text-accent-gold font-medium">Rp {{ number_format($v->price_adjustment, 0, ',', '.') }}</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-1">
                                <button onclick="document.getElementById('var-modal-{{ $v->id }}').classList.toggle('hidden')" class="p-1.5 hover:bg-admin-bg rounded-lg transition-colors">
                                    <span class="material-symbols-outlined text-lg text-text-muted hover:text-accent-gold">edit</span>
                                </button>
                                <form method="POST" action="{{ route('admin.variants.destroy', $v) }}" onsubmit="return confirm('Hapus varian ini?')">
                                    @csrf @method('DELETE')
                                    <button class="p-1.5 hover:bg-admin-bg rounded-lg transition-colors">
                                        <span class="material-symbols-outlined text-lg text-text-muted hover:text-red-400">delete</span>
                                    </button>
                                </form>
                            </div>
                            {{-- Edit Modal --}}
                            <div id="var-modal-{{ $v->id }}" class="hidden fixed inset-0 bg-black/60 z-50 flex items-center justify-center" onclick="if(event.target===this)this.classList.add('hidden')">
                                <div class="bg-admin-card border border-admin-border rounded-2xl p-6 w-96">
                                    <h4 class="font-semibold mb-4">Edit Varian #{{ $v->id }}</h4>
                                    <form method="POST" action="{{ route('admin.variants.update', $v) }}">
                                        @csrf @method('PUT')
                                        <div class="space-y-3">
                                            <div>
                                                <label class="text-xs text-text-muted">Ukuran</label>
                                                <input type="text" name="size" value="{{ $v->size }}" required class="w-full bg-admin-bg border border-admin-border rounded-xl px-4 py-2.5 text-sm text-text-primary">
                                            </div>
                                            <div>
                                                <label class="text-xs text-text-muted">Stok</label>
                                                <input type="number" name="stock" value="{{ $v->stock }}" required min="0" class="w-full bg-admin-bg border border-admin-border rounded-xl px-4 py-2.5 text-sm text-text-primary">
                                            </div>
                                            <div>
                                                <label class="text-xs text-text-muted">Harga (Rp)</label>
                                                <input type="number" name="price_adjustment" value="{{ $v->price_adjustment }}" required min="0" class="w-full bg-admin-bg border border-admin-border rounded-xl px-4 py-2.5 text-sm text-text-primary">
                                            </div>
                                        </div>
                                        <div class="flex gap-2 mt-4">
                                            <button type="submit" class="flex-1 bg-accent-emerald text-admin-bg py-2.5 rounded-xl text-sm font-semibold">Simpan</button>
                                            <button type="button" onclick="this.closest('[id^=var-modal]').classList.add('hidden')" class="flex-1 bg-admin-bg border border-admin-border py-2.5 rounded-xl text-sm">Batal</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="7" class="text-center py-12 text-text-muted">
                        <span class="material-symbols-outlined text-4xl block mb-2">style</span>Belum ada varian produk
                    </td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($variants->hasPages())
        <div class="px-6 py-4 border-t border-admin-border">{{ $variants->withQueryString()->links('admin.components.pagination') }}</div>
        @endif
    </div>
</div>
@endsection
