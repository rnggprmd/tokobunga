@extends('admin.layouts.app')
@section('title', 'Tambah Custom Request')
@section('subtitle', 'Input permintaan kustom secara manual')

@section('content')
<div class="max-w-4xl">
    <a href="{{ route('admin.custom-requests.index') }}" class="inline-flex items-center gap-1 text-sm text-text-muted hover:text-accent-emerald transition-colors mb-6">
        <span class="material-symbols-outlined text-lg">arrow_back</span> Kembali ke Daftar Request
    </a>

    <div class="glass-card rounded-3xl overflow-hidden">
        <div class="px-8 py-6 border-b border-admin-border bg-white/50">
            <h3 class="font-bold text-lg flex items-center gap-2">
                <span class="material-symbols-outlined text-accent-emerald">edit_note</span> Form Request Baru
            </h3>
        </div>

        <form action="{{ route('admin.custom-requests.store') }}" method="POST" enctype="multipart/form-data" class="p-8 space-y-6">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Customer Info --}}
                <div class="space-y-4">
                    <h4 class="text-xs font-bold text-text-muted uppercase tracking-wider mb-2">Informasi Pembeli</h4>
                    
                    <div>
                        <label class="text-xs text-text-muted mb-1 block">Nama Pembeli</label>
                        <input type="text" name="customer_name" required
                            class="w-full bg-admin-bg border border-admin-border rounded-xl px-4 py-2.5 text-sm focus:border-accent-emerald outline-none">
                    </div>

                    <div>
                        <label class="text-xs text-text-muted mb-1 block">Email (Opsional)</label>
                        <input type="email" name="customer_email"
                            class="w-full bg-admin-bg border border-admin-border rounded-xl px-4 py-2.5 text-sm focus:border-accent-emerald outline-none">
                    </div>

                    <div>
                        <label class="text-xs text-text-muted mb-1 block">No. HP / WhatsApp</label>
                        <input type="text" name="customer_phone"
                            class="w-full bg-admin-bg border border-admin-border rounded-xl px-4 py-2.5 text-sm focus:border-accent-emerald outline-none">
                    </div>
                </div>

                {{-- Request Details --}}
                <div class="space-y-4">
                    <h4 class="text-xs font-bold text-text-muted uppercase tracking-wider mb-2">Detail Permintaan</h4>

                    <div>
                        <label class="text-xs text-text-muted mb-1 block">Kategori Produk</label>
                        <input type="text" name="product_category" placeholder="Contoh: Buket Pernikahan, Papan Bunga"
                            class="w-full bg-admin-bg border border-admin-border rounded-xl px-4 py-2.5 text-sm focus:border-accent-emerald outline-none">
                    </div>

                    <div>
                        <label class="text-xs text-text-muted mb-1 block">Harga Estimasi (Rp)</label>
                        <input type="number" name="harga_estimasi" value="0"
                            class="w-full bg-admin-bg border border-admin-border rounded-xl px-4 py-2.5 text-sm focus:border-accent-emerald outline-none font-mono">
                    </div>

                    <div>
                        <label class="text-xs text-text-muted mb-1 block">Keterangan / Detail Request</label>
                        <textarea name="keterangan" rows="4" required
                            class="w-full bg-admin-bg border border-admin-border rounded-xl px-4 py-2.5 text-sm focus:border-accent-emerald outline-none"></textarea>
                    </div>

                    <div>
                        <label class="text-xs text-text-muted mb-1 block">Foto Referensi</label>
                        <input type="file" name="foto_referensi"
                            class="w-full text-xs text-text-muted file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-accent-emerald/10 file:text-accent-emerald hover:file:bg-accent-emerald/20">
                    </div>
                </div>
            </div>

            <div class="pt-6 border-t border-admin-border flex justify-end gap-3">
                <button type="submit" class="px-8 py-3 bg-accent-emerald text-white rounded-xl text-sm font-bold shadow-lg shadow-accent-emerald/20 hover:opacity-90 transition-opacity flex items-center gap-2">
                    <span class="material-symbols-outlined text-lg">save</span> Simpan Request
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
