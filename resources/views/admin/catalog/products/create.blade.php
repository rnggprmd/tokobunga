@extends('admin.layouts.app')
@section('title', 'Tambah Produk')
@section('subtitle', 'Tambahkan produk baru ke katalog')

@section('content')
<div class="max-w-5xl">
    <a href="{{ route('admin.products.index') }}" class="inline-flex items-center gap-1 text-sm text-text-muted hover:text-accent-emerald transition-colors mb-6">
        <span class="material-symbols-outlined text-lg">arrow_back</span> Kembali
    </a>

    <div class="glass-card rounded-2xl p-8">
        <form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data" class="space-y-6">
            @csrf
            <div>
                <label class="text-sm font-medium mb-2 block">Foto Produk</label>
                <div class="relative group h-40 bg-admin-bg border-2 border-dashed border-admin-border rounded-2xl flex flex-col items-center justify-center cursor-pointer hover:border-accent-emerald transition-colors overflow-hidden">
                    <input type="file" name="foto" id="foto-input" accept="image/*" class="absolute inset-0 opacity-0 cursor-pointer z-10" onchange="previewImage(event)">
                    <div id="preview-placeholder" class="text-center group-hover:scale-110 transition-transform">
                        <span class="material-symbols-outlined text-4xl text-text-muted">image</span>
                        <p class="text-xs text-text-muted mt-2">Klik untuk unggah foto</p>
                    </div>
                    <img id="image-preview" src="" class="hidden absolute inset-0 w-full h-full object-cover">
                </div>
                @error('foto')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="text-sm font-medium mb-2 block">Nama Produk <span class="text-red-400">*</span></label>
                <input type="text" name="nama_produk" value="{{ old('nama_produk') }}" required
                    class="w-full bg-admin-bg border border-admin-border rounded-xl px-4 py-3 text-sm text-text-primary focus:border-accent-emerald focus:ring-1 focus:ring-accent-emerald outline-none transition-colors"
                    placeholder="Contoh: Bunga Kantil">
                @error('nama_produk')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="text-sm font-medium mb-2 block">Kategori <span class="text-red-400">*</span></label>
                <select name="category_id" required
                    class="w-full bg-admin-bg border border-admin-border rounded-xl px-4 py-3 text-sm text-text-primary focus:border-accent-emerald outline-none">
                    <option value="">Pilih Kategori</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->nama_kategori }}</option>
                    @endforeach
                </select>
                @error('category_id')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="text-sm font-medium mb-2 block">Deskripsi</label>
                <textarea name="deskripsi" rows="4"
                    class="w-full bg-admin-bg border border-admin-border rounded-xl px-4 py-3 text-sm text-text-primary focus:border-accent-emerald focus:ring-1 focus:ring-accent-emerald outline-none resize-none"
                    placeholder="Deskripsi produk...">{{ old('deskripsi') }}</textarea>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="text-sm font-medium mb-2 block">Harga (Rp) <span class="text-red-400">*</span></label>
                    <input type="number" name="harga" value="{{ old('harga', 0) }}" required min="0" step="100"
                        class="w-full bg-admin-bg border border-admin-border rounded-xl px-4 py-3 text-sm text-text-primary focus:border-accent-emerald outline-none">
                    @error('harga')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="text-sm font-medium mb-2 block">Stok <span class="text-red-400">*</span></label>
                    <input type="number" name="stok" value="{{ old('stok', 0) }}" required min="0"
                        class="w-full bg-admin-bg border border-admin-border rounded-xl px-4 py-3 text-sm text-text-primary focus:border-accent-emerald outline-none">
                    @error('stok')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
            </div>



            <div class="flex gap-3 pt-4">
                <button type="submit" class="px-8 py-3 bg-accent-emerald text-admin-bg rounded-xl text-sm font-semibold hover:opacity-90 transition-opacity">
                    <span class="material-symbols-outlined text-lg align-middle mr-1">add</span> Simpan Produk
                </button>
                <a href="{{ route('admin.products.index') }}" class="px-8 py-3 bg-admin-bg border border-admin-border rounded-xl text-sm hover:bg-admin-card-hover transition-colors">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function previewImage(event) {
        const reader = new FileReader();
        const file = event.target.files[0];
        const preview = document.getElementById('image-preview');
        const placeholder = document.getElementById('preview-placeholder');

        reader.onload = function() {
            if (preview) {
                preview.src = reader.result;
                preview.classList.remove('hidden');
                if (placeholder) placeholder.classList.add('hidden');
            }
        }

        if (file) {
            reader.readAsDataURL(file);
        }
    }
</script>
@endpush
