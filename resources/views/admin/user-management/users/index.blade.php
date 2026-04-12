@extends('admin.layouts.app')
@section('title', 'Manajemen Users')
@section('subtitle', 'Kelola akun pengguna sistem')

@section('content')
<div class="space-y-6">
    <div class="glass-card rounded-2xl p-6">
        <form method="GET" class="flex flex-wrap gap-4 items-end">
            <div class="flex-1 min-w-[200px]">
                <label class="text-xs text-text-muted mb-1 block">Cari User</label>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Nama atau email..."
                    class="w-full bg-admin-bg border border-admin-border rounded-xl px-4 py-2.5 text-sm text-text-primary focus:border-accent-emerald outline-none">
            </div>
            <div class="w-40">
                <label class="text-xs text-text-muted mb-1 block">Role</label>
                <select name="role" class="w-full bg-admin-bg border border-admin-border rounded-xl px-4 py-2.5 text-sm text-text-primary focus:border-accent-emerald outline-none">
                    <option value="">Semua Role</option>
                    <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="customer" {{ request('role') == 'customer' ? 'selected' : '' }}>Customer</option>
                </select>
            </div>
            <button class="px-6 py-2.5 bg-accent-emerald/10 text-accent-emerald rounded-xl text-sm font-medium hover:bg-accent-emerald/20 transition-colors">
                <span class="material-symbols-outlined text-lg align-middle mr-1">filter_list</span> Filter
            </button>
            @if(request()->hasAny(['search','role']))
                <a href="{{ route('admin.users.index') }}" class="px-4 py-2.5 text-text-muted text-sm">Reset</a>
            @endif
        </form>
    </div>

    <div class="glass-card rounded-2xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-text-muted text-xs uppercase tracking-wider bg-admin-bg/50">
                        <th class="text-left px-6 py-4">ID</th>
                        <th class="text-left px-6 py-4">User</th>
                        <th class="text-left px-6 py-4">Email</th>
                        <th class="text-left px-6 py-4">Role</th>
                        <th class="text-left px-6 py-4">No HP</th>
                        <th class="text-left px-6 py-4">Bergabung</th>
                        <th class="text-left px-6 py-4">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-admin-border/50">
                    @forelse($users as $user)
                    <tr class="hover:bg-admin-card-hover/50 transition-colors">
                        <td class="px-6 py-4 font-mono text-text-muted">#{{ $user->id }}</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 bg-gradient-to-br {{ $user->role == 'admin' ? 'from-accent-emerald to-accent-emerald-dim' : 'from-accent-rose to-accent-rose-dim' }} rounded-full flex items-center justify-center text-sm font-bold text-white">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                                <span class="font-medium">{{ $user->name }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-text-muted">{{ $user->email }}</td>
                        <td class="px-6 py-4">
                            <span class="px-2.5 py-1 rounded-full text-xs font-medium {{ $user->role == 'admin' ? 'bg-accent-emerald/10 text-accent-emerald' : 'bg-blue-500/10 text-blue-400' }}">
                                {{ ucfirst($user->role) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-text-muted">{{ $user->no_hp ?? '-' }}</td>
                        <td class="px-6 py-4 text-text-muted">{{ $user->created_at->format('d M Y') }}</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-1">
                                <button onclick="document.getElementById('user-modal-{{ $user->id }}').classList.toggle('hidden')" class="p-1.5 hover:bg-admin-bg rounded-lg transition-colors" title="Edit Role">
                                    <span class="material-symbols-outlined text-lg text-text-muted hover:text-accent-gold">edit</span>
                                </button>
                                @if($user->id !== auth()->id())
                                <form method="POST" action="{{ route('admin.users.destroy', $user) }}" onsubmit="return confirm('Hapus user {{ $user->name }}?')">
                                    @csrf @method('DELETE')
                                    <button class="p-1.5 hover:bg-admin-bg rounded-lg transition-colors">
                                        <span class="material-symbols-outlined text-lg text-text-muted hover:text-red-400">delete</span>
                                    </button>
                                </form>
                                @endif
                            </div>
                            {{-- Role Modal --}}
                            <div id="user-modal-{{ $user->id }}" class="hidden fixed inset-0 bg-black/60 z-50 flex items-center justify-center" onclick="if(event.target===this)this.classList.add('hidden')">
                                <div class="bg-admin-card border border-admin-border rounded-2xl p-6 w-96">
                                    <h4 class="font-semibold mb-4">Update Role — {{ $user->name }}</h4>
                                    <form method="POST" action="{{ route('admin.users.updateRole', $user) }}">
                                        @csrf @method('PATCH')
                                        <select name="role" class="w-full bg-admin-bg border border-admin-border rounded-xl px-4 py-2.5 text-sm mb-4 text-text-primary">
                                            <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                                            <option value="customer" {{ $user->role == 'customer' ? 'selected' : '' }}>Customer</option>
                                        </select>
                                        <div class="flex gap-2">
                                            <button type="submit" class="flex-1 bg-accent-emerald text-admin-bg py-2.5 rounded-xl text-sm font-semibold">Simpan</button>
                                            <button type="button" onclick="this.closest('[id^=user-modal]').classList.add('hidden')" class="flex-1 bg-admin-bg border border-admin-border py-2.5 rounded-xl text-sm">Batal</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="7" class="text-center py-12 text-text-muted">
                        <span class="material-symbols-outlined text-4xl block mb-2">group</span>Belum ada user
                    </td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($users->hasPages())
        <div class="px-6 py-4 border-t border-admin-border">{{ $users->withQueryString()->links('admin.components.pagination') }}</div>
        @endif
    </div>
</div>
@endsection
