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
            <div class="w-48">
                <label class="text-xs text-text-muted mb-1 block">Status</label>
                <select name="status" class="w-full bg-admin-bg border border-admin-border rounded-xl px-4 py-2.5 text-sm text-text-primary focus:border-accent-emerald outline-none">
                    <option value="">Semua Status</option>
                    @foreach(['pending','approved','rejected','in_progress','done'] as $s)
                        <option value="{{ $s }}" {{ request('status') == $s ? 'selected' : '' }}>{{ ucfirst(str_replace('_', ' ', $s)) }}</option>
                    @endforeach
                </select>
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

                        <th class="text-left px-6 py-4">Status</th>
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

                        <td class="px-6 py-4">
                            @php
                                $colors = ['pending'=>'bg-yellow-500/10 text-yellow-400','approved'=>'bg-blue-500/10 text-blue-400','rejected'=>'bg-red-500/10 text-red-400','in_progress'=>'bg-purple-500/10 text-purple-400','done'=>'bg-emerald-500/10 text-emerald-400'];
                            @endphp
                            <span class="px-2.5 py-1 rounded-full text-xs font-medium {{ $colors[$cr->status] ?? '' }}">{{ ucfirst(str_replace('_', ' ', $cr->status)) }}</span>
                        </td>
                        <td class="px-6 py-4 text-text-muted">{{ $cr->created_at->format('d M Y') }}</td>
                        <td class="px-6 py-4">
                            <button onclick="document.getElementById('cr-modal-{{ $cr->id }}').classList.toggle('hidden')" class="p-1.5 hover:bg-admin-bg rounded-lg transition-colors">
                                <span class="material-symbols-outlined text-lg text-text-muted hover:text-accent-gold">edit</span>
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="8" class="text-center py-12 text-text-muted">
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

    @foreach($customRequests as $cr)
    <div id="cr-modal-{{ $cr->id }}" class="hidden fixed inset-0 bg-black/60 z-50 flex items-center justify-center" onclick="if(event.target===this)this.classList.add('hidden')">
        <div class="bg-admin-card border border-admin-border rounded-2xl p-6 w-96">
            <h4 class="font-semibold mb-4 text-text-primary">Update Custom Request #{{ $cr->id }}</h4>
            <form method="POST" action="{{ route('admin.custom-requests.updateStatus', $cr) }}">
                @csrf @method('PATCH')
                <div class="space-y-3">
                    <div>
                        <label class="text-xs text-text-muted">Status</label>
                        <select name="status" class="w-full bg-admin-bg border border-admin-border rounded-xl px-4 py-2.5 text-sm text-text-primary outline-none focus:border-accent-emerald">
                            @foreach(['pending','approved','rejected','in_progress','done'] as $s)
                                <option value="{{ $s }}" {{ $cr->status == $s ? 'selected' : '' }}>{{ ucfirst(str_replace('_', ' ', $s)) }}</option>
                            @endforeach
                        </select>
                    </div>

                </div>
                <div class="flex gap-2 mt-4">
                    <button type="submit" class="flex-1 bg-accent-emerald text-admin-bg py-2.5 rounded-xl text-sm font-semibold hover:opacity-90 transition-opacity">Simpan</button>
                    <button type="button" onclick="this.closest('[id^=cr-modal]').classList.add('hidden')" class="flex-1 bg-admin-bg border border-admin-border py-2.5 rounded-xl text-sm text-text-primary hover:bg-admin-card-hover transition-colors">Batal</button>
                </div>
            </form>
        </div>
    </div>
    @endforeach
</div>
@endsection
