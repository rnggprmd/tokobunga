@extends('admin.layouts.app')
@section('title', 'Custom Requests')
@section('subtitle', 'Kelola permintaan custom pelanggan')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold">Custom Request</h2>
            <p class="text-sm text-text-muted">Kelola permintaan kustom dari pelanggan</p>
        </div>
        <a href="{{ route('admin.custom-requests.create') }}" class="px-5 py-2.5 bg-accent-emerald text-admin-bg rounded-xl text-sm font-bold flex items-center gap-2 hover:opacity-90 transition-opacity">
            <span class="material-symbols-outlined">add</span> Tambah Request
        </a>
    </div>

    <div class="glass-card rounded-2xl p-6">
        <form method="GET" class="flex flex-wrap gap-4 items-end">
            <div class="flex-1 min-w-[200px]">
                <label class="text-xs text-text-muted mb-1 block">Cari Request</label>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Customer, Kategori, atau Keterangan..."
                    class="w-full bg-admin-bg border border-admin-border rounded-xl px-4 py-2.5 text-sm text-text-primary focus:border-accent-emerald outline-none">
            </div>

            <button type="submit" class="px-6 py-2.5 bg-accent-emerald/10 text-accent-emerald rounded-xl text-sm font-medium hover:bg-accent-emerald/20 transition-colors">
                <span class="material-symbols-outlined text-lg align-middle mr-1">filter_list</span> Filter
            </button>
            @if(request()->hasAny(['search','status']))
                <a href="{{ route('admin.custom-requests.index') }}" class="px-4 py-2.5 text-text-muted text-sm hover:text-text-primary transition-colors">Reset</a>
            @endif
        </form>
    </div>

    <div class="glass-card rounded-2xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-text-muted text-xs uppercase tracking-wider bg-admin-bg/50">
                        <th class="text-left px-6 py-4">ID</th>
                        <th class="text-left px-6 py-4">Customer</th>
                        <th class="text-left px-6 py-4">Kategori</th>
                        <th class="text-left px-6 py-4">Keterangan</th>


                        <th class="text-left px-6 py-4">Tanggal</th>
                        <th class="text-left px-6 py-4">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-admin-border/50">
                    @forelse($customRequests as $cr)
                    <tr class="hover:bg-admin-card-hover/50 transition-colors">
                        <td class="px-6 py-4 font-mono text-text-muted">#{{ $cr->id }}</td>
                        <td class="px-6 py-4">
                            <div class="font-medium">{{ $cr->customer_name ?? ($cr->user->name ?? '-') }}</div>
                            <div class="text-xs text-text-muted">{{ $cr->customer_email ?? '' }}</div>
                        </td>
                        <td class="px-6 py-4 text-text-muted">{{ $cr->product_category ?? '-' }}</td>
                        <td class="px-6 py-4 max-w-[200px] truncate text-text-muted" title="{{ $cr->keterangan }}">{{ $cr->keterangan ?? '-' }}</td>


                        <td class="px-6 py-4 text-text-muted">{{ $cr->created_at->format('d M Y') }}</td>
                        <td class="px-6 py-4">
                            <button onclick="document.getElementById('cr-modal-{{ $cr->id }}').classList.toggle('hidden')" class="p-1.5 hover:bg-admin-bg rounded-lg transition-colors">
                                <span class="material-symbols-outlined text-lg text-text-muted hover:text-accent-gold">edit</span>
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="text-center py-12 text-text-muted">
                        <span class="material-symbols-outlined text-4xl block mb-2">edit_note</span>Belum ada custom request
                    </td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($customRequests->hasPages())
        <div class="px-6 py-4 border-t border-admin-border">{{ $customRequests->withQueryString()->links('admin.components.pagination') }}</div>
        @endif
    </div>

@push('modals')
    @foreach($customRequests as $cr)
    <div id="cr-modal-{{ $cr->id }}" class="hidden fixed inset-0 bg-black/60 z-[100] flex items-center justify-center p-4 backdrop-blur-sm" onclick="if(event.target===this)this.classList.add('hidden')">
        <div class="bg-white rounded-3xl p-8 w-full max-w-lg shadow-2xl relative animate-fade-in text-left">
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h4 class="text-xl font-bold text-text-primary">Edit Custom Request</h4>
                    <p class="text-xs text-text-muted mt-1">ID Request: #{{ $cr->id }}</p>
                </div>
                <button onclick="document.getElementById('cr-modal-{{ $cr->id }}').classList.add('hidden')" class="w-10 h-10 flex items-center justify-center rounded-full bg-admin-bg text-text-muted hover:text-text-primary transition-colors">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>
            
            <form method="POST" action="{{ route('admin.custom-requests.update', $cr) }}" class="space-y-6">
                @csrf @method('PUT')
                
                <div class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="text-[10px] font-bold text-text-muted uppercase tracking-widest mb-2 block">Nama Pembeli</label>
                            <input type="text" name="customer_name" value="{{ $cr->customer_name }}" required
                                class="w-full bg-admin-bg border border-admin-border rounded-xl px-4 py-3 text-sm focus:border-accent-emerald outline-none transition-all font-medium">
                        </div>
                        <div>
                            <label class="text-[10px] font-bold text-text-muted uppercase tracking-widest mb-2 block">No. HP / WhatsApp</label>
                            <input type="text" name="customer_phone" value="{{ $cr->customer_phone }}"
                                class="w-full bg-admin-bg border border-admin-border rounded-xl px-4 py-3 text-sm focus:border-accent-emerald outline-none transition-all font-medium">
                        </div>
                    </div>

                    <div>
                        <label class="text-[10px] font-bold text-text-muted uppercase tracking-widest mb-2 block">Kategori Produk</label>
                        <input type="text" name="product_category" value="{{ $cr->product_category }}"
                            class="w-full bg-admin-bg border border-admin-border rounded-xl px-4 py-3 text-sm focus:border-accent-emerald outline-none transition-all font-medium">
                    </div>

                    <div>
                        <label class="text-[10px] font-bold text-text-muted uppercase tracking-widest mb-2 block">Keterangan / Detail Request</label>
                        <textarea name="keterangan" rows="4" required
                            class="w-full bg-admin-bg border border-admin-border rounded-xl px-4 py-3 text-sm focus:border-accent-emerald outline-none transition-all font-medium">{{ $cr->keterangan }}</textarea>
                    </div>
                </div>

                <div class="flex gap-3 pt-2">
                    <button type="submit" class="flex-1 bg-accent-emerald text-white py-4 rounded-xl text-sm font-bold shadow-lg shadow-accent-emerald/20 hover:opacity-90 transition-all">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
    @endforeach
@endpush
</div>
@endsection
