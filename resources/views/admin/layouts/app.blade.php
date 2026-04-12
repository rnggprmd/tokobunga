<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Panel — Mbah Bibit</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Newsreader:ital,opsz,wght@0,6..72,400;1,6..72,400&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'admin-bg': '#FAFAE3',
                        'admin-surface': '#A5A68F',
                        'admin-card': '#ffffff',
                        'admin-card-hover': '#f4f4d0',
                        'admin-border': '#D9D9C3',
                        'admin-border-light': '#E5E5D5',
                        'accent-emerald': '#8F9E83',
                        'accent-emerald-dim': '#C6D1BE',
                        'accent-gold': '#D9C5A9',
                        'accent-gold-dim': '#E9DFD0',
                        'accent-rose': '#D9B2A9',
                        'accent-rose-dim': '#EBD6D1',
                        'text-primary': '#2C2E2A',
                        'text-secondary': '#4A4E46',
                        'text-muted': '#7A7F75',
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        serif: ['Newsreader', 'serif'],
                    }
                }
            }
        }
    </script>

    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 300, 'GRAD' 0, 'opsz' 24;
        }
        body { font-family: 'Inter', sans-serif; }
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: #FAFAE3; }
        ::-webkit-scrollbar-thumb { background: #A5A68F; border-radius: 3px; }
        ::-webkit-scrollbar-thumb:hover { background: #8E8F7A; }

        .sidebar-link {
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            border-left: 3px solid transparent;
            color: #FFFFFF;
        }
        .sidebar-link:hover {
            background: rgba(255, 255, 255, 0.1);
            color: #FFFFFF;
        }
        .sidebar-link.active {
            background: #D9B2A9;
            color: #FAFAE3 !important;
            border-left-color: #FAFAE3;
            font-weight: 600;
        }
        .sidebar-link.active .material-symbols-outlined {
            color: #FAFAE3 !important;
        }
        .sidebar-link.active .material-symbols-outlined {
            font-variation-settings: 'FILL' 1, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(10px);
            border: 1px solid #D9D9C3;
            box-shadow: 0 4px 20px rgba(165, 166, 143, 0.1);
        }

        .stat-card { transition: all 0.3s ease; }
        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.3);
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in { animation: fadeInUp 0.5s ease forwards; }
        .animate-fade-in-delay-1 { animation: fadeInUp 0.5s ease 0.1s forwards; opacity: 0; }
        .animate-fade-in-delay-2 { animation: fadeInUp 0.5s ease 0.2s forwards; opacity: 0; }
        .animate-fade-in-delay-3 { animation: fadeInUp 0.5s ease 0.3s forwards; opacity: 0; }
    </style>
</head>
<body class="bg-admin-bg text-text-primary min-h-screen">
    <div class="flex min-h-screen relative">
        {{-- Mobile Overlay --}}
        <div id="sidebar-overlay" class="fixed inset-0 bg-black/50 z-40 hidden lg:hidden backdrop-blur-sm transition-opacity duration-300 opacity-0" onclick="toggleSidebar()"></div>

        {{-- Sidebar --}}
        <aside class="w-72 bg-admin-surface border-r border-admin-border flex flex-col fixed h-full z-50 transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out" id="sidebar">
            {{-- Logo --}}
            <div class="px-6 py-6 border-b border-admin-border">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center backdrop-blur-sm border border-white/10">
                        <span class="material-symbols-outlined text-white text-lg">local_florist</span>
                    </div>
                    <div>
                        <h1 class="text-lg font-bold text-white tracking-tight">Mbah Bibit</h1>
                        <p class="text-[10px] text-white/60 uppercase tracking-[0.2em]">Admin Panel</p>
                    </div>
                </div>
            </div>

            {{-- Navigation --}}
            <nav class="flex-1 py-4 px-3 space-y-1 overflow-y-auto">
                <a href="{{ route('admin.dashboard') }}"
                   class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <span class="material-symbols-outlined text-xl">dashboard</span>
                    Dashboard
                </a>

                <div class="pt-4 pb-2 px-4">
                    <p class="text-[10px] uppercase tracking-[0.2em] text-white/50 font-semibold">Manajemen Operasional</p>
                </div>
                <a href="{{ route('admin.orders.index') }}"
                   class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                    <span class="material-symbols-outlined text-xl">shopping_cart</span>
                    Order / Pesanan
                </a>
                <a href="{{ route('admin.payments.index') }}"
                   class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm {{ request()->routeIs('admin.payments.*') ? 'active' : '' }}">
                    <span class="material-symbols-outlined text-xl">payments</span>
                    Pembayaran
                </a>
                <a href="{{ route('admin.shipping.index') }}"
                   class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm {{ request()->routeIs('admin.shipping.*') ? 'active' : '' }}">
                    <span class="material-symbols-outlined text-xl">local_shipping</span>
                    Pengiriman
                </a>
                <a href="{{ route('admin.order-items.index') }}"
                   class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm {{ request()->routeIs('admin.order-items.*') ? 'active' : '' }}">
                    <span class="material-symbols-outlined text-xl">receipt_long</span>
                    Order Items
                </a>
                <a href="{{ route('admin.custom-requests.index') }}"
                   class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm {{ request()->routeIs('admin.custom-requests.*') ? 'active' : '' }}">
                    <span class="material-symbols-outlined text-xl">edit_note</span>
                    Custom Request
                </a>

                <div class="pt-4 pb-2 px-4">
                    <p class="text-[10px] uppercase tracking-[0.2em] text-white/50 font-semibold">Manajemen Produk</p>
                </div>
                <a href="{{ route('admin.products.index') }}"
                   class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                    <span class="material-symbols-outlined text-xl">local_florist</span>
                    Products
                </a>
                <a href="{{ route('admin.variants.index') }}"
                   class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm {{ request()->routeIs('admin.variants.*') ? 'active' : '' }}">
                    <span class="material-symbols-outlined text-xl">style</span>
                    Varian Produk
                </a>
                <a href="{{ route('admin.categories.index') }}"
                   class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                    <span class="material-symbols-outlined text-xl">category</span>
                    Categories
                </a>

                <div class="pt-4 pb-2 px-4">
                    <p class="text-[10px] uppercase tracking-[0.2em] text-white/50 font-semibold">Manajemen Users</p>
                </div>
                <a href="{{ route('admin.users.index') }}"
                   class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                    <span class="material-symbols-outlined text-xl">group</span>
                    Users
                </a>

                <div class="pt-4 pb-2 px-4">
                    <p class="text-[10px] uppercase tracking-[0.2em] text-white/50 font-semibold">Statistik</p>
                </div>
                <a href="{{ route('admin.reports.index') }}"
                   class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm {{ request()->routeIs('admin.reports.*') ? 'active' : '' }}">
                    <span class="material-symbols-outlined text-xl">analytics</span>
                    Laporan
                </a>
            </nav>

            {{-- User / Logout --}}
            <div class="p-4 border-t border-admin-border">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 bg-white/20 rounded-full flex items-center justify-center text-sm font-bold text-white backdrop-blur-sm border border-white/10">
                        {{ substr(auth()->user()->name, 0, 1) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium truncate text-white">{{ auth()->user()->name }}</p>
                        <p class="text-[10px] text-white/60 truncate">{{ auth()->user()->email }}</p>
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-white/60 hover:text-white transition-colors" title="Logout">
                            <span class="material-symbols-outlined text-xl">logout</span>
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        {{-- Main Content --}}
        <div class="flex-1 w-full lg:ml-72 min-h-screen flex flex-col">
            {{-- Topbar --}}
            <header class="sticky top-0 z-20 bg-admin-bg/80 backdrop-blur-xl border-b border-admin-border px-4 lg:px-8 py-4">
                <div class="flex items-center justify-between gap-4">
                    <div class="flex items-center gap-4">
                        <button onclick="toggleSidebar()" class="lg:hidden p-2 hover:bg-admin-surface rounded-lg text-text-secondary transition-colors">
                            <span class="material-symbols-outlined text-2xl">menu</span>
                        </button>
                        <div>
                            <h2 class="text-lg lg:text-xl font-semibold">@yield('title', 'Dashboard')</h2>
                            <p class="text-[10px] lg:text-xs text-text-muted mt-0.5">@yield('subtitle', 'Selamat datang')</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3 lg:gap-4 shrink-0">
                        <div class="text-right hidden sm:block">
                            <p class="text-[10px] text-text-muted" id="live-date"></p>
                            <p class="text-xs lg:text-sm font-mono text-accent-emerald" id="live-clock"></p>
                        </div>
                        <a href="{{ url('/') }}" class="flex items-center gap-2 px-3 lg:px-4 py-2 rounded-lg bg-white hover:bg-admin-bg border border-admin-border text-xs lg:text-sm text-text-secondary hover:text-text-primary transition-all shadow-sm">
                            <span class="material-symbols-outlined text-lg">storefront</span>
                            <span class="hidden md:inline">Lihat Toko</span>
                        </a>
                    </div>
                </div>
            </header>

            {{-- Flash Messages --}}
            @if(session('success'))
                <div class="mx-8 mt-4 px-4 py-3 bg-accent-emerald-dim/30 border border-accent-emerald/20 rounded-xl text-accent-emerald text-sm flex items-center gap-2" id="flash-success">
                    <span class="material-symbols-outlined text-lg">check_circle</span>
                    {{ session('success') }}
                    <button onclick="document.getElementById('flash-success').remove()" class="ml-auto"><span class="material-symbols-outlined text-lg">close</span></button>
                </div>
            @endif
            @if(session('error'))
                <div class="mx-8 mt-4 px-4 py-3 bg-red-900/30 border border-red-500/20 rounded-xl text-red-400 text-sm flex items-center gap-2" id="flash-error">
                    <span class="material-symbols-outlined text-lg">error</span>
                    {{ session('error') }}
                    <button onclick="document.getElementById('flash-error').remove()" class="ml-auto"><span class="material-symbols-outlined text-lg">close</span></button>
                </div>
            @endif

            {{-- Page Content --}}
            <main class="p-8">
                @yield('content')
            </main>
        </div>
    </div>

    <script>
        function updateClock() {
            const now = new Date();
            const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
            document.getElementById('live-date').textContent = now.toLocaleDateString('id-ID', options);
            document.getElementById('live-clock').textContent = now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit', second: '2-digit' });
        }
        updateClock();
        setInterval(updateClock, 1000);

        // Auto-hide flash messages
        setTimeout(() => {
            const flash = document.getElementById('flash-success') || document.getElementById('flash-error');
            if (flash) flash.style.opacity = '0';
            setTimeout(() => { if (flash) flash.remove(); }, 500);
        }, 4000);

        // Sidebar Toggle
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebar-overlay');
            const isOpen = !sidebar.classList.contains('-translate-x-full');

            if (isOpen) {
                sidebar.classList.add('-translate-x-full');
                overlay.classList.add('hidden');
                overlay.classList.remove('opacity-100');
                overlay.classList.add('opacity-0');
                document.body.style.overflow = '';
            } else {
                sidebar.classList.remove('-translate-x-full');
                overlay.classList.remove('hidden');
                setTimeout(() => {
                    overlay.classList.remove('opacity-0');
                    overlay.classList.add('opacity-100');
                }, 10);
                document.body.style.overflow = 'hidden';
            }
        }
    </script>

    @stack('scripts')
</body>
</html>
