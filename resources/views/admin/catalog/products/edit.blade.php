@extends('admin.layouts.app')
@section('title', 'Edit Produk')
@section('subtitle', 'Perbarui data produk')

@section('content')
<div class="max-w-5xl">
    <a href="{{ route('admin.products.index') }}" class="inline-flex items-center gap-1 text-sm text-text-muted hover:text-accent-emerald transition-colors mb-6">
        <span class="material-symbols-outlined text-lg">arrow_back</span> Kembali
    </a>

    <div class="glass-card rounded-2xl p-8">
        <form method="POST" action="{{ route('admin.products.update', $product) }}" enctype="multipart/form-data" class="space-y-6">
            @csrf @method('PUT')
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-6">
                    <div>
                        <label class="text-sm font-medium mb-2 block">Nama Produk <span class="text-red-400">*</span></label>
                        <input type="text" name="nama_produk" value="{{ old('nama_produk', $product->nama_produk) }}" required
                            class="w-full bg-admin-bg border border-admin-border rounded-xl px-4 py-3 text-sm text-text-primary focus:border-accent-emerald focus:ring-1 focus:ring-accent-emerald outline-none">
                        @error('nama_produk')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="text-sm font-medium mb-2 block">Kategori <span class="text-red-400">*</span></label>
                        <select name="category_id" required
                            class="w-full bg-admin-bg border border-admin-border rounded-xl px-4 py-3 text-sm text-text-primary focus:border-accent-emerald outline-none">
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ old('category_id', $product->category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->nama_kategori }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="space-y-6">
                    <div>
                        <label class="text-sm font-medium mb-2 block">Foto Produk (Kosongkan jika tidak ingin mengubah)</label>
                        <div class="relative group h-40 bg-admin-bg border-2 border-dashed border-admin-border rounded-2xl flex flex-col items-center justify-center cursor-pointer hover:border-accent-emerald transition-colors overflow-hidden">
                            <input type="file" name="foto" id="foto-input" accept="image/*" class="absolute inset-0 opacity-0 cursor-pointer z-10" onchange="previewImage(event)">
                            <div id="preview-placeholder" class="text-center {{ $product->foto ? 'hidden' : '' }} group-hover:scale-110 transition-transform">
                                <span class="material-symbols-outlined text-4xl text-text-muted">image</span>
                                <p class="text-xs text-text-muted mt-2">Klik untuk ganti foto</p>
                            </div>
                            <img id="image-preview" src="{{ $product->foto ? asset('storage/' . $product->foto) : '' }}" class="{{ $product->foto ? '' : 'hidden' }} absolute inset-0 w-full h-full object-cover">
                        </div>
                        @error('foto')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>
            </div>

            <div>
                <label class="text-sm font-medium mb-2 block">Deskripsi</label>
                <textarea name="deskripsi" rows="4"
                    class="w-full bg-admin-bg border border-admin-border rounded-xl px-4 py-3 text-sm text-text-primary focus:border-accent-emerald outline-none resize-none">{{ old('deskripsi', $product->deskripsi) }}</textarea>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="text-sm font-medium mb-2 block">Harga (Rp) <span class="text-red-400">*</span></label>
                    <input type="number" name="harga" value="{{ old('harga', $product->harga) }}" required min="0" step="100"
                        class="w-full bg-admin-bg border border-admin-border rounded-xl px-4 py-3 text-sm text-text-primary focus:border-accent-emerald outline-none">
                </div>
                <div>
                    <label class="text-sm font-medium mb-2 block">Stok <span class="text-red-400">*</span></label>
                    <input type="number" name="stok" value="{{ old('stok', $product->stok) }}" required min="0"
                        class="w-full bg-admin-bg border border-admin-border rounded-xl px-4 py-3 text-sm text-text-primary focus:border-accent-emerald outline-none">
                </div>
            </div>



            <div class="flex gap-3 pt-4">
                <button type="submit" class="px-8 py-3 bg-accent-emerald text-admin-bg rounded-xl text-sm font-semibold hover:opacity-90 transition-opacity">
                    <span class="material-symbols-outlined text-lg align-middle mr-1">save</span> Simpan Perubahan
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
