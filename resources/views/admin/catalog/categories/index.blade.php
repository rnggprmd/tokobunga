@extends('admin.layouts.app')
@section('title', 'Manajemen Kategori')
@section('subtitle', 'Kelola kategori produk toko')

@section('content')
<div class="space-y-6">
    {{-- Add Category --}}
    <div class="glass-card rounded-2xl p-6">
        <h3 class="font-semibold mb-4 flex items-center gap-2">
            <span class="material-symbols-outlined text-accent-emerald">add_circle</span> Tambah Kategori Baru
        </h3>
        <form method="POST" action="{{ route('admin.categories.store') }}" class="flex flex-wrap gap-4 items-end">
            @csrf
            <div class="flex-1 min-w-[200px]">
                <label class="text-xs text-text-muted mb-1 block">Nama Kategori</label>
                <input type="text" name="nama_kategori" required placeholder="Contoh: Bunga Segar"
                    class="w-full bg-admin-bg border border-admin-border rounded-xl px-4 py-2.5 text-sm text-text-primary focus:border-accent-emerald outline-none">
            </div>
            <div class="flex-1 min-w-[200px]">
                <label class="text-xs text-text-muted mb-1 block">Deskripsi (opsional)</label>
                <input type="text" name="deskripsi" placeholder="Deskripsi singkat..."
                    class="w-full bg-admin-bg border border-admin-border rounded-xl px-4 py-2.5 text-sm text-text-primary focus:border-accent-emerald outline-none">
            </div>
            <button class="px-6 py-2.5 bg-accent-emerald text-admin-bg rounded-xl text-sm font-semibold hover:opacity-90 transition-opacity">
                <span class="material-symbols-outlined text-lg align-middle mr-1">add</span> Tambah
            </button>
        </form>
    </div>

    {{-- Categories Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($categories as $cat)
        <div class="glass-card rounded-2xl p-6 stat-card">
            <div class="flex items-start justify-end mb-4">
                <div class="flex gap-1">
                    <button onclick="document.getElementById('cat-modal-{{ $cat->id }}').classList.toggle('hidden')" class="p-1.5 hover:bg-admin-bg rounded-lg transition-colors">
                        <span class="material-symbols-outlined text-lg text-text-muted hover:text-accent-gold">edit</span>
                    </button>
                    <form method="POST" action="{{ route('admin.categories.destroy', $cat) }}" onsubmit="return confirm('Hapus kategori ini? Semua produk di dalamnya juga akan terhapus.')">
                        @csrf @method('DELETE')
                        <button class="p-1.5 hover:bg-admin-bg rounded-lg transition-colors">
                            <span class="material-symbols-outlined text-lg text-text-muted hover:text-red-400">delete</span>
                        </button>
                    </form>
                </div>
            </div>
            <h3 class="text-lg font-semibold">{{ $cat->nama_kategori }}</h3>
            <p class="text-sm text-text-muted mt-1">{{ $cat->deskripsi ?? 'Tidak ada deskripsi' }}</p>
            <div class="mt-4 pt-4 border-t border-admin-border/50 flex items-center justify-between">
                <span class="text-sm text-text-muted">
                    <strong class="text-text-primary">{{ $cat->products_count }}</strong> produk
                </span>
                <span class="text-xs text-text-muted">{{ $cat->created_at->format('d M Y') }}</span>
            </div>

            {{-- Edit Modal --}}
            <div id="cat-modal-{{ $cat->id }}" class="hidden fixed inset-0 bg-black/60 z-50 flex items-center justify-center" onclick="if(event.target===this)this.classList.add('hidden')">
                <div class="bg-admin-card border border-admin-border rounded-2xl p-6 w-96">
                    <h4 class="font-semibold mb-4">Edit Kategori</h4>
                    <form method="POST" action="{{ route('admin.categories.update', $cat) }}">
                        @csrf @method('PUT')
                        <div class="space-y-3">
                            <div>
                                <label class="text-xs text-text-muted">Nama Kategori</label>
                                <input type="text" name="nama_kategori" value="{{ $cat->nama_kategori }}" required class="w-full bg-admin-bg border border-admin-border rounded-xl px-4 py-2.5 text-sm text-text-primary">
                            </div>
                            <div>
                                <label class="text-xs text-text-muted">Deskripsi</label>
                                <input type="text" name="deskripsi" value="{{ $cat->deskripsi }}" class="w-full bg-admin-bg border border-admin-border rounded-xl px-4 py-2.5 text-sm text-text-primary">
                            </div>
                        </div>
                        <div class="flex gap-2 mt-4">
                            <button type="submit" class="flex-1 bg-accent-emerald text-admin-bg py-2.5 rounded-xl text-sm font-semibold">Simpan</button>
                            <button type="button" onclick="this.closest('[id^=cat-modal]').classList.add('hidden')" class="flex-1 bg-admin-bg border border-admin-border py-2.5 rounded-xl text-sm">Batal</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-3 glass-card rounded-2xl p-12 text-center text-text-muted">
            <span class="material-symbols-outlined text-5xl block mb-3">category</span>
            <p>Belum ada kategori.</p>
        </div>
        @endforelse
    </div>

    @if($categories->hasPages())
    <div class="glass-card rounded-2xl p-4">{{ $categories->links('admin.components.pagination') }}</div>
    @endif
</div>
@endsection
