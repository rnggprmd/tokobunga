<!DOCTYPE html>
<html class="light" lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>@yield('title', 'Mbah Bibit - Botanical Heritage')</title>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Newsreader:ital,opsz,wght@0,6..72,200..800;1,6..72,200..800&family=Manrope:wght@200..800&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    "colors": {
                        "background": "#FAFAE3",
                        "primary": "#D9B2A9",
                        "secondary": "#A5A68F",
                        "on-background": "#1b1d0f",
                        "surface": "#fbfbe4",
                        "outline": "#78776e",
                        "accent-rose": "#D9B2A9",
                        "admin-border": "#e4e4ce",
                    },
                    "fontFamily": {
                        "headline": ["Newsreader", "serif"],
                        "body": ["Manrope", "sans-serif"],
                    }
                },
            }
        }
    </script>
    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        body { font-family: 'Manrope', sans-serif; }
        .serif-italic { font-family: 'Newsreader', serif; font-style: italic; }
        .serif-bold { font-family: 'Newsreader', serif; font-weight: 700; }
        .glass-nav { background: rgba(251, 251, 228, 0.8); backdrop-filter: blur(12px); }
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;  
            overflow: hidden;
        }
    </style>
    @stack('styles')
</head>
<body class="bg-background text-on-background selection:bg-primary/20">
    <!-- TopNavBar -->
    <nav x-data="{ mobileMenuOpen: false }" class="sticky top-0 z-50 w-full bg-[#fbfbe4]/80 backdrop-blur-md border-b border-primary/10">
        <div class="flex justify-between items-center w-full px-8 py-4 max-w-screen-2xl mx-auto">
            <div class="flex items-center gap-4">
                {{-- Hamburger Button --}}
                <button @click="mobileMenuOpen = !mobileMenuOpen" class="md:hidden text-secondary">
                    <span class="material-symbols-outlined" x-text="mobileMenuOpen ? 'close' : 'menu'">menu</span>
                </button>
                <a href="{{ route('home') }}" class="text-2xl font-serif font-bold text-secondary uppercase tracking-widest">
                    Mbah Bibit
                </a>
            </div>

            <div class="hidden md:flex gap-8 items-center">
                {{-- Desktop Links --}}
                <a class="text-secondary hover:text-primary font-sans font-medium transition-colors duration-300 {{ request()->routeIs('home') ? 'border-b-2 border-primary pb-0.5 serif-italic' : 'text-secondary/80' }}" href="{{ route('home') }}">
                    Beranda
                </a>

                <div class="relative group">
                    <button class="text-secondary/80 hover:text-primary font-sans font-medium transition-colors duration-300 flex items-center gap-1">
                        Kategori
                        <span class="material-symbols-outlined text-sm">expand_more</span>
                    </button>
                    <div class="absolute left-0 mt-2 w-48 bg-background border border-admin-border rounded-2xl shadow-xl py-2 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-[60]">
                        @foreach($categories as $navCat)
                        <a href="{{ route('products.index', ['category' => $navCat->id]) }}" class="block px-4 py-2 text-xs font-bold text-secondary hover:bg-primary/10 hover:text-primary transition-colors">
                            {{ $navCat->nama_kategori }}
                        </a>
                        @endforeach
                    </div>
                </div>

                <a class="text-secondary/80 hover:text-primary font-sans font-medium transition-colors duration-300 {{ request()->routeIs('products.index') && !request('category') ? 'border-b-2 border-primary pb-0.5 serif-italic' : '' }}" href="{{ route('products.index') }}">
                    Produk
                </a>

                <a class="text-secondary/80 hover:text-primary font-sans font-medium transition-colors duration-300 {{ request()->routeIs('custom.create') ? 'border-b-2 border-primary pb-0.5 serif-italic' : '' }}" href="{{ route('custom.create') }}">
                    Custom
                </a>

                <a class="text-secondary/80 hover:text-primary font-sans font-medium transition-colors duration-300 {{ request()->routeIs('orders.track') ? 'border-b-2 border-primary pb-0.5 serif-italic' : '' }}" href="{{ route('orders.track') }}">
                    Lacak Pesanan
                </a>
            </div>

            <div class="flex items-center gap-6">
                {{-- Cart & Icons --}}
                <div class="flex items-baseline gap-4">
                    <a href="{{ route('wishlist.index') }}" class="text-secondary hover:text-primary scale-90 duration-200 relative group">
                        <span class="material-symbols-outlined">favorite</span>
                        @auth
                            @php
                                $wishlistCount = \App\Models\Wishlist::where('user_id', Auth::id())->count();
                            @endphp
                            @if($wishlistCount > 0)
                                <span class="absolute -top-1 -right-1 w-3.5 h-3.5 bg-accent-rose text-[8px] flex items-center justify-center text-white rounded-full font-bold transition-opacity">
                                    {{ $wishlistCount }}
                                </span>
                            @endif
                        @endauth
                    </a>

                    <a href="{{ route('cart.index') }}" class="text-secondary hover:text-primary scale-95 duration-200 relative">
                        <span class="material-symbols-outlined">shopping_bag</span>
                        <span class="absolute -top-1 -right-1 w-3.5 h-3.5 bg-primary text-[8px] flex items-center justify-center text-white rounded-full font-bold">
                            {{ session('cart') ? count(session('cart')) : 0 }}
                        </span>
                    </a>
                </div>

                @auth
                    <div class="hidden sm:flex items-center gap-4">
                        <a href="{{ route('profile.index') }}" class="text-secondary scale-95 duration-200 hover:text-primary">
                            <span class="material-symbols-outlined">person</span>
                        </a>
                        <form action="{{ route('logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="text-secondary scale-95 duration-200 hover:text-red-500">
                                <span class="material-symbols-outlined">logout</span>
                            </button>
                        </form>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="hidden sm:flex text-xs font-black uppercase tracking-widest text-secondary hover:text-primary transition-colors items-center gap-1">
                        <span class="material-symbols-outlined text-lg">login</span>
                        Masuk
                    </a>
                @endauth
            </div>
        </div>

        {{-- Mobile Drawer --}}
        <div x-show="mobileMenuOpen" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="-translate-x-full"
             x-transition:enter-end="translate-x-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="translate-x-0"
             x-transition:leave-end="-translate-x-full"
             class="fixed inset-0 z-[100] md:hidden"
             style="display: none;">
            
            <div @click="mobileMenuOpen = false" class="absolute inset-0 bg-secondary/20 backdrop-blur-sm"></div>
            
            <div class="absolute left-0 top-0 bottom-0 w-80 bg-background border-r border-primary/20 p-8 space-y-12">
                <div class="flex justify-between items-center">
                    <span class="text-xl font-serif font-bold text-secondary uppercase tracking-widest">Mbah Bibit</span>
                    <button @click="mobileMenuOpen = false" class="text-secondary">
                        <span class="material-symbols-outlined">close</span>
                    </button>
                </div>

                <div class="space-y-6">
                    <nav class="flex flex-col gap-6">
                        <a href="{{ route('home') }}" class="text-2xl font-headline text-secondary {{ request()->routeIs('home') ? 'serif-italic text-primary' : '' }}">Beranda</a>
                        
                        <div class="space-y-4">
                            <p class="text-[10px] font-black uppercase tracking-widest text-secondary/40">Koleksi Berdasarkan Kategori</p>
                            <div class="grid grid-cols-1 gap-4">
                                @foreach($categories as $navCat)
                                <a href="{{ route('products.index', ['category' => $navCat->id]) }}" class="text-lg text-secondary/80 hover:text-primary">{{ $navCat->nama_kategori }}</a>
                                @endforeach
                            </div>
                        </div>

                        <a href="{{ route('products.index') }}" class="text-2xl font-headline text-secondary">Produk</a>
                        <a href="{{ route('custom.create') }}" class="text-2xl font-headline text-secondary">Custom Order</a>
                        <a href="{{ route('orders.track') }}" class="text-2xl font-headline text-secondary">Lacak Pesanan</a>
                    </nav>

                    <div class="pt-12 border-t border-primary/10">
                        @auth
                            <a href="{{ route('profile.index') }}" class="block w-full bg-surface border border-primary/20 text-secondary mb-4 py-4 rounded-full font-bold text-center uppercase tracking-widest text-xs">Profil Akun</a>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full bg-secondary text-white py-4 rounded-full font-bold uppercase tracking-widest text-xs">Logout</button>
                            </form>
                        @else
                            <a href="{{ route('login') }}" class="block w-full bg-primary text-white py-4 rounded-full font-bold text-center uppercase tracking-widest text-xs">Masuk Akun</a>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-[#FAFAE3] text-secondary py-12 px-12 border-t border-secondary/10 mt-24">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-12 max-w-screen-2xl mx-auto">
            <div class="space-y-4">
                <div class="text-lg font-serif font-semibold">Toko Bunga Mbah Bibit</div>
                <p class="font-sans text-sm tracking-wide text-secondary/80">Preserving the ritual essence of nature since 1978. Every specimen tells a story of heritage and respect.</p>
            </div>
            <div class="space-y-4">
                <h4 class="font-label font-bold uppercase text-[10px] tracking-[0.2em]">Navigation</h4>
                <ul class="font-sans text-sm space-y-2">
                    <li><a class="text-[#5e604c] hover:opacity-70 transition-colors" href="{{ route('home') }}">Beranda</a></li>
                    <li><a class="text-[#5e604c] hover:opacity-70 transition-colors" href="{{ route('products.index') }}">Produk</a></li>
                    <li><a class="text-[#5e604c] hover:opacity-70 transition-colors" href="{{ route('custom.create') }}">Custom</a></li>
                    <li><a class="text-[#5e604c] hover:opacity-70 transition-colors" href="{{ route('orders.track') }}">Lacak Pesanan</a></li>
                </ul>
            </div>
            <div class="space-y-4">
                <h4 class="font-label font-bold uppercase text-[10px] tracking-[0.2em]">Contact</h4>
                <ul class="font-sans text-sm space-y-2">
                    <li class="text-[#5e604c]">Madiun, Jawa Timur</li>
                    <li class="text-[#5e604c]">toko@mbahbibit.com</li>
                    <li class="text-[#5e604c]">+62 812 3456 7890</li>
                </ul>
            </div>
            <div class="space-y-4">
                <h4 class="font-label font-bold uppercase text-[10px] tracking-[0.2em]">Location</h4>
                <div class="rounded-xl overflow-hidden h-32 border border-secondary/10">
                    <iframe 
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d126588.35414842795!2d110.74838708688726!3d-7.560060965386047!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e7a16627039efc1%3A0x6333bf698d276d47!2sSolo%2C%20Kota%20Surakarta%2C%20Jawa%20Tengah!5e0!3m2!1sid!2sid!4v1713000000000!5m2!1sid!2sid" 
                        class="w-full h-full border-0" 
                        allowfullscreen="" 
                        loading="lazy">
                    </iframe>
                </div>
            </div>
        </div>
        <div class="max-w-screen-2xl mx-auto mt-12 pt-8 border-t border-[#5e604c]/5 flex flex-col md:flex-row justify-between items-center gap-4">
            <p class="font-sans text-xs tracking-wide text-[#5e604c] opacity-60">© 2026 Toko Bunga Mbah Bibit.</p>
            <div class="flex gap-6">
                <a class="material-symbols-outlined text-lg" href="#">share</a>
                <a class="material-symbols-outlined text-lg" href="#">photo_camera</a>
                <a class="material-symbols-outlined text-lg" href="#">mail</a>
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
