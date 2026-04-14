<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Panel Kurir — Mbah Bibit</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Newsreader:ital,opsz,wght@0,6..72,400;1,6..72,400&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>

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
            font-variation-settings: 'FILL' 1, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        .glass-card {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(10px);
            border: 1px solid #D9D9C3;
            box-shadow: 0 4px 20px rgba(165, 166, 143, 0.1);
        }
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in { animation: fadeInUp 0.5s ease forwards; }
    </style>
</head>
<body class="bg-admin-bg text-text-primary min-h-screen overflow-x-hidden">
    <div class="flex min-h-screen relative">
        {{-- Mobile Overlay --}}
        <div id="sidebar-overlay" class="fixed inset-0 bg-black/50 z-40 hidden lg:hidden backdrop-blur-sm transition-opacity duration-300 opacity-0" onclick="toggleSidebar()"></div>

        {{-- Sidebar --}}
        <aside class="w-72 bg-admin-surface border-r border-admin-border flex flex-col fixed inset-y-0 left-0 z-50 transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out" id="sidebar">
            {{-- Logo --}}
            <div class="px-6 py-8 border-b border-admin-border/30">
                <a href="{{ route('kurir.dashboard') }}" class="flex items-center justify-center">
                    <img src="{{ asset('images/logo.png') }}" alt="Mbah Bibit Logo" class="h-20 w-auto object-contain filter brightness-0 invert opacity-90">
                </a>
            </div>

            {{-- Navigation --}}
            <nav class="flex-1 py-4 px-3 space-y-1 overflow-y-auto">
                <a href="{{ route('kurir.dashboard') }}"
                   class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm {{ request()->routeIs('kurir.dashboard') ? 'active' : '' }}">
                    <span class="material-symbols-outlined text-xl">dashboard</span>
                    Dashboard
                </a>

                <div class="pt-4 pb-2 px-4">
                    <p class="text-[10px] uppercase tracking-[0.2em] text-white/50 font-semibold">Pengiriman</p>
                </div>
                <a href="{{ route('kurir.pengiriman.index') }}"
                   class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm {{ request()->routeIs('kurir.pengiriman.index') ? 'active' : '' }}">
                    <span class="material-symbols-outlined text-xl">local_shipping</span>
                    Tugas Pengiriman
                </a>
                <a href="{{ route('kurir.pengiriman.history') }}"
                   class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm {{ request()->routeIs('kurir.pengiriman.history') ? 'active' : '' }}">
                    <span class="material-symbols-outlined text-xl">history</span>
                    Riwayat Pengiriman
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
                        <p class="text-[10px] text-white/60 truncate">Kurir</p>
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
        <div class="flex-1 min-w-0 w-full lg:pl-72 min-h-screen flex flex-col">
            {{-- Topbar --}}
            <header class="sticky top-0 z-20 bg-admin-bg/80 backdrop-blur-xl border-b border-admin-border px-4 lg:px-8 py-4">
                <div class="flex items-center justify-between gap-4">
                    <div class="flex items-center gap-4">
                        <button onclick="toggleSidebar()" class="lg:hidden p-2 hover:bg-admin-surface rounded-lg text-text-secondary transition-colors">
                            <span class="material-symbols-outlined text-2xl">menu</span>
                        </button>
                        <div>
                            <h2 class="text-lg lg:text-xl font-semibold">@yield('title', 'Dashboard Kurir')</h2>
                            <p class="text-[10px] lg:text-xs text-text-muted mt-0.5">@yield('subtitle', 'Panel Kurir Mbah Bibit')</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3 lg:gap-4 shrink-0">
                        <div class="text-right hidden sm:block">
                            <p class="text-[10px] text-text-muted" id="live-date"></p>
                            <p class="text-xs lg:text-sm font-mono text-accent-emerald" id="live-clock"></p>
                        </div>
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

            {{-- Page Content --}}
            <main class="p-8 w-full overflow-x-hidden">
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

        setTimeout(() => {
            const flash = document.getElementById('flash-success');
            if (flash) { flash.style.opacity = '0'; setTimeout(() => flash.remove(), 500); }
        }, 4000);

        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebar-overlay');
            const isOpen = !sidebar.classList.contains('-translate-x-full');
            if (isOpen) {
                sidebar.classList.add('-translate-x-full');
                overlay.classList.add('hidden');
                document.body.style.overflow = '';
            } else {
                sidebar.classList.remove('-translate-x-full');
                overlay.classList.remove('hidden');
                setTimeout(() => { overlay.classList.remove('opacity-0'); overlay.classList.add('opacity-100'); }, 10);
                document.body.style.overflow = 'hidden';
            }
        }

        // Live Location Tracking for Courier
        if ("geolocation" in navigator) {
            let lastUpdate = 0;
            const updateInterval = 20000; // Update every 20 seconds

            navigator.geolocation.watchPosition(
                (position) => {
                    const now = Date.now();
                    if (now - lastUpdate < updateInterval) return;
                    
                    lastUpdate = now;
                    const { latitude, longitude } = position.coords;

                    fetch("{{ route('kurir.location.update') }}", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "Accept": "application/json",
                            "X-CSRF-TOKEN": "{{ csrf_token() }}"
                        },
                        body: JSON.stringify({ latitude, longitude })
                    })
                    .then(response => response.json())
                    .then(data => console.log('Location updated:', data))
                    .catch(err => console.error('Location update failed:', err));
                },
                (error) => console.warn('Geolocation error:', error.message),
                { enableHighAccuracy: true, maximumAge: 30000, timeout: 27000 }
            );
        }
    </script>
    @stack('scripts')
</body>
</html>
