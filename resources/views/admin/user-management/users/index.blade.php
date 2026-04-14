@extends('admin.layouts.app')
@section('title', 'Manajemen Users')
@section('subtitle', 'Kelola akun pengguna sistem')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between mb-2 px-2">
        <div>
            <h2 class="text-xl font-bold text-text-primary">Daftar Pengguna</h2>
            <p class="text-xs text-text-muted">Total {{ $users->total() }} user terdaftar dalam sistem</p>
        </div>
        <button onclick="document.getElementById('add-user-modal').classList.remove('hidden')" class="px-6 py-2.5 bg-accent-emerald text-white rounded-xl text-sm font-semibold hover:opacity-90 transition-all flex items-center gap-2 shadow-lg shadow-accent-emerald/20">
            <span class="material-symbols-outlined text-lg">person_add</span>
            Tambah User
        </button>
    </div>

    <div class="glass-card rounded-2xl p-6">
        <form method="GET" class="flex flex-wrap gap-4 items-end">
            <div class="flex-1 min-w-[200px]">
                <label class="text-xs text-text-muted mb-1.5 block font-medium">Cari User</label>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Nama atau email..."
                    class="w-full bg-admin-bg border border-admin-border rounded-xl px-4 py-2.5 text-sm text-text-primary focus:border-accent-emerald outline-none transition-colors">
            </div>
            <div class="w-48">
                <label class="text-xs text-text-muted mb-1.5 block font-medium">Filter Role</label>
                <select name="role" class="w-full bg-admin-bg border border-admin-border rounded-xl px-4 py-2.5 text-sm text-text-primary focus:border-accent-emerald outline-none">
                    <option value="">Semua Role</option>
                    <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="customer" {{ request('role') == 'customer' ? 'selected' : '' }}>Customer</option>
                    <option value="kurir" {{ request('role') == 'kurir' ? 'selected' : '' }}>Kurir</option>
                </select>
            </div>
            <button type="submit" class="px-6 py-2.5 bg-accent-emerald/10 text-accent-emerald rounded-xl text-sm font-bold hover:bg-accent-emerald/20 transition-colors">
                Filter
            </button>
            @if(request()->hasAny(['search','role']))
                <a href="{{ route('admin.users.index') }}" class="px-4 py-2.5 text-text-muted text-sm hover:text-text-primary transition-colors">Reset</a>
            @endif
        </form>
    </div>

    <div class="glass-card rounded-2xl overflow-hidden border border-admin-border/50">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-text-muted text-[10px] uppercase font-bold tracking-[0.1em] bg-admin-bg/50">
                        <th class="text-left px-6 py-5">ID</th>
                        <th class="text-left px-6 py-5">User</th>
                        <th class="text-left px-6 py-5">Email</th>
                        <th class="text-left px-6 py-5">Role</th>
                        <th class="text-left px-6 py-5">No HP</th>
                        <th class="text-left px-6 py-5">Bergabung</th>
                        <th class="text-right px-6 py-5">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-admin-border/30">
                    @forelse($users as $user)
                    <tr class="hover:bg-admin-card-hover/30 transition-colors group">
                        <td class="px-6 py-4 font-mono text-[11px] text-text-muted">#{{ $user->id }}</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-gradient-to-br {{ $user->role == 'admin' ? 'from-accent-emerald to-accent-emerald-dim' : ($user->role == 'kurir' ? 'from-accent-surface to-admin-border' : 'from-accent-rose to-accent-rose-dim') }} rounded-xl flex items-center justify-center text-sm font-bold text-white shadow-sm">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                                <div>
                                    <p class="font-bold text-text-primary">{{ $user->name }}</p>
                                    <p class="text-[10px] text-text-muted uppercase tracking-wider">{{ $user->role }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-text-secondary font-medium">{{ $user->email }}</td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 rounded-lg text-[10px] font-bold uppercase tracking-wider 
                                {{ $user->role == 'admin' ? 'bg-accent-emerald/10 text-accent-emerald' : ($user->role == 'kurir' ? 'bg-admin-surface/10 text-admin-surface' : 'bg-blue-500/10 text-blue-500') }}">
                                {{ $user->role }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-text-muted font-mono text-xs">{{ $user->no_hp ?? '-' }}</td>
                        <td class="px-6 py-4 text-text-muted text-xs">{{ $user->created_at->format('d M Y') }}</td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-1">
                                <button onclick="document.getElementById('user-modal-{{ $user->id }}').classList.remove('hidden')" class="w-9 h-9 flex items-center justify-center hover:bg-accent-gold/10 rounded-lg transition-colors group/btn" title="Edit Detail">
                                    <span class="material-symbols-outlined text-lg text-text-muted group-hover/btn:text-accent-gold transition-colors">edit</span>
                                </button>
                                @if($user->id !== auth()->id())
                                <form method="POST" action="{{ route('admin.users.destroy', $user) }}" onsubmit="return confirm('Hapus user {{ $user->name }}?')">
                                    @csrf @method('DELETE')
                                    <button class="w-9 h-9 flex items-center justify-center hover:bg-red-500/10 rounded-lg transition-colors group/btn">
                                        <span class="material-symbols-outlined text-lg text-text-muted group-hover/btn:text-red-500 transition-colors">delete</span>
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="7" class="text-center py-20 text-text-muted">
                        <div class="flex flex-col items-center gap-2">
                            <span class="material-symbols-outlined text-5xl opacity-20">group_off</span>
                            <p class="font-medium">Tidak ada data pengguna ditemukan</p>
                            <p class="text-xs opacity-60">Coba ubah kata kunci pencarian atau filter Anda</p>
                        </div>
                    </td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($users->hasPages())
        <div class="px-6 py-4 border-t border-admin-border bg-admin-bg/30">{{ $users->withQueryString()->links('admin.components.pagination') }}</div>
        @endif
    </div>
</div>

</div>

{{-- Render All User Edit Modals outside the loop/table to prevent layout breaking --}}
@foreach($users as $user)
    <div id="user-modal-{{ $user->id }}" class="hidden fixed inset-0 bg-black/60 z-[60] flex items-center justify-center p-4 backdrop-blur-sm text-left" onclick="if(event.target===this)this.classList.add('hidden')">
        <div class="bg-white rounded-3xl p-8 w-full max-w-lg shadow-2xl relative animate-fade-in">
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h4 class="text-xl font-bold text-text-primary">Edit Data Pengguna</h4>
                    <p class="text-xs text-text-muted mt-1">ID Pengguna: #{{ $user->id }}</p>
                </div>
                <button onclick="document.getElementById('user-modal-{{ $user->id }}').classList.add('hidden')" class="w-10 h-10 flex items-center justify-center rounded-full bg-admin-bg text-text-muted hover:text-text-primary transition-colors">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>
            
            <form method="POST" action="{{ route('admin.users.update', $user) }}" class="space-y-6">
                @csrf @method('PUT')
                
                <div class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="text-[10px] font-bold text-text-muted uppercase tracking-widest mb-2 block">Nama Lengkap</label>
                            <input type="text" name="name" value="{{ $user->name }}" required
                                class="w-full bg-admin-bg border border-admin-border rounded-xl px-4 py-3 text-sm focus:border-accent-emerald outline-none transition-all font-medium">
                        </div>
                        <div>
                            <label class="text-[10px] font-bold text-text-muted uppercase tracking-widest mb-2 block">Alamat Email</label>
                            <input type="email" name="email" value="{{ $user->email }}" required
                                class="w-full bg-admin-bg border border-admin-border rounded-xl px-4 py-3 text-sm focus:border-accent-emerald outline-none transition-all font-medium">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="text-[10px] font-bold text-text-muted uppercase tracking-widest mb-2 block">Nomor HP</label>
                            <input type="text" name="no_hp" value="{{ $user->no_hp }}" placeholder="08..."
                                class="w-full bg-admin-bg border border-admin-border rounded-xl px-4 py-3 text-sm focus:border-accent-emerald outline-none transition-all font-medium">
                        </div>
                        <div>
                            <label class="text-[10px] font-bold text-text-muted uppercase tracking-widest mb-2 block">Hak Akses (Role)</label>
                            <select name="role" class="w-full bg-admin-bg border border-admin-border rounded-xl px-4 py-3 text-sm focus:border-accent-emerald outline-none appearance-none cursor-pointer font-medium">
                                <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                                <option value="kurir" {{ $user->role == 'kurir' ? 'selected' : '' }}>Kurir</option>
                                <option value="customer" {{ $user->role == 'customer' ? 'selected' : '' }}>Customer</option>
                            </select>
                        </div>
                    </div>

                    <div class="p-4 bg-admin-bg/50 rounded-2xl border border-admin-border/30">
                        <div class="flex items-center gap-2 text-text-muted mb-1">
                            <span class="material-symbols-outlined text-sm">calendar_today</span>
                            <span class="text-[10px] uppercase font-bold tracking-widest">Informasi Bergabung</span>
                        </div>
                        <p class="text-xs font-semibold text-text-secondary ml-6">{{ $user->created_at->format('d F Y') }} <span class="text-text-muted font-normal">pukul {{ $user->created_at->format('H:i') }}</span></p>
                    </div>
                </div>

                <div class="flex gap-3 pt-2">
                    <button type="submit" class="flex-1 bg-accent-emerald text-white py-4 rounded-xl text-sm font-bold shadow-lg shadow-accent-emerald/20 hover:opacity-90 transition-all">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
@endforeach

{{-- Add User Modal --}}
<div id="add-user-modal" class="hidden fixed inset-0 bg-black/60 z-[60] flex items-center justify-center p-4 backdrop-blur-sm" onclick="if(event.target===this)this.classList.add('hidden')">
    <div class="bg-white rounded-3xl p-8 w-full max-w-lg shadow-2xl relative animate-fade-in">
        <div class="flex items-center justify-between mb-8">
            <div>
                <h4 class="text-xl font-bold text-text-primary">Tambah Pengguna Baru</h4>
                <p class="text-xs text-text-muted mt-1">Buat akun admin atau customer baru</p>
            </div>
            <button onclick="document.getElementById('add-user-modal').classList.add('hidden')" class="w-10 h-10 flex items-center justify-center rounded-full bg-admin-bg text-text-muted hover:text-text-primary transition-colors">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>
        
        <form method="POST" action="{{ route('admin.users.store') }}" class="space-y-6">
            @csrf
            <div class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="text-[10px] font-bold text-text-muted uppercase tracking-widest mb-2 block">Nama Lengkap <span class="text-red-500">*</span></label>
                        <input type="text" name="name" required placeholder="Nama user..."
                            class="w-full bg-admin-bg border border-admin-border rounded-xl px-4 py-3 text-sm focus:border-accent-emerald outline-none transition-all font-medium">
                    </div>
                    <div>
                        <label class="text-[10px] font-bold text-text-muted uppercase tracking-widest mb-2 block">Email <span class="text-red-500">*</span></label>
                        <input type="email" name="email" required placeholder="email@example.com"
                            class="w-full bg-admin-bg border border-admin-border rounded-xl px-4 py-3 text-sm focus:border-accent-emerald outline-none transition-all font-medium">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="text-[10px] font-bold text-text-muted uppercase tracking-widest mb-2 block">Nomor HP</label>
                        <input type="text" name="no_hp" placeholder="08..."
                            class="w-full bg-admin-bg border border-admin-border rounded-xl px-4 py-3 text-sm focus:border-accent-emerald outline-none transition-all font-medium">
                    </div>
                    <div>
                        <label class="text-[10px] font-bold text-text-muted uppercase tracking-widest mb-2 block">Role <span class="text-red-500">*</span></label>
                        <select name="role" required class="w-full bg-admin-bg border border-admin-border rounded-xl px-4 py-3 text-sm focus:border-accent-emerald outline-none appearance-none cursor-pointer font-medium">
                            <option value="customer">Customer</option>
                            <option value="kurir">Kurir</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="text-[10px] font-bold text-text-muted uppercase tracking-widest mb-2 block">Password Akun <span class="text-red-500">*</span></label>
                    <input type="password" name="password" required placeholder="Minimal 8 karakter"
                        class="w-full bg-admin-bg border border-admin-border rounded-xl px-4 py-3 text-sm focus:border-accent-emerald outline-none transition-all font-medium">
                </div>
            </div>

            <div class="flex gap-3 pt-2">
                <button type="submit" class="flex-1 bg-accent-emerald text-white py-4 rounded-xl text-sm font-bold shadow-lg shadow-accent-emerald/20 hover:opacity-90 transition-all">Daftarkan Pengguna</button>
            </div>
        </form>
    </div>
</div>
@endsection
