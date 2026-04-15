@extends('layouts.front')

@section('title', 'Katalog Botanikal — Mbah Bibit')

@section('content')

{{-- === TOP RULE === --}}
<div class="w-full border-t border-secondary/20"></div>

<div class="max-w-screen-xl mx-auto">

    {{-- === MASTHEAD === --}}
    <div class="grid grid-cols-12 border-b border-secondary/20">
        {{-- Label col --}}
        <div class="col-span-12 md:col-span-3 border-b md:border-b-0 md:border-r border-secondary/20 px-8 py-6 flex items-center">
            <div>
                <p class="text-[9px] font-black uppercase tracking-[0.3em] text-secondary/40">Mbah Bibit Studio</p>
                <p class="text-[9px] font-black uppercase tracking-[0.3em] text-secondary/40 mt-0.5">Koleksi Produk</p>
            </div>
        </div>
        {{-- Headline col --}}
        <div class="col-span-12 md:col-span-9 px-8 md:px-16 py-12 flex flex-col md:flex-row md:items-end justify-between gap-8">
            <h1 class="font-headline text-[clamp(3rem,8vw,6rem)] text-secondary leading-none tracking-tight">
                Katalog<br><span class="serif-italic text-primary">Produk</span>
            </h1>
            
            {{-- Quick Search --}}
            <form action="{{ route('products.index') }}" method="GET" class="w-full md:w-72 group">
                <div class="relative border-b border-secondary/20 focus-within:border-secondary transition-colors">
                    <input type="text" name="search" value="{{ request('search') }}" 
                           class="w-full bg-transparent border-none p-0 pb-2 text-sm text-secondary placeholder:text-secondary/20 focus:ring-0 focus:outline-none font-bold uppercase tracking-widest"
                           placeholder="CARI PRODUK ···">
                    <button type="submit" class="absolute right-0 bottom-2 text-secondary/40 group-hover:text-primary transition-colors">
                        <span class="material-symbols-outlined text-sm">search</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- === BODY AREA === --}}
    <div class="grid grid-cols-12">

        {{-- LEFT: Filters --}}
        <aside class="col-span-12 md:col-span-3 border-b md:border-b-0 md:border-r border-secondary/20">
            <div class="px-8 py-12 sticky top-24 space-y-12">
                
                {{-- Categories Index --}}
                <div class="space-y-6">
                    <p class="text-[10px] font-black uppercase tracking-[0.3em] text-secondary/30">Indeks Kategori</p>
                    <ul class="space-y-4">
                        <li>
                            <a href="{{ route('products.index') }}" 
                               class="group flex items-center justify-between text-[11px] font-black uppercase tracking-widest {{ !request('category') ? 'text-primary' : 'text-secondary/50 hover:text-secondary transition-colors' }}">
                                <span>SEMUA PRODUK</span>
                                <span class="w-1.5 h-1.5 rounded-full {{ !request('category') ? 'bg-primary' : 'bg-transparent group-hover:bg-secondary/20' }}"></span>
                            </a>
                        </li>
                        @foreach($categories as $category)
                        <li>
                            <a href="{{ route('products.index', ['category' => $category->id]) }}" 
                               class="group flex items-center justify-between text-[11px] font-black uppercase tracking-widest {{ request('category') == $category->id ? 'text-primary' : 'text-secondary/50 hover:text-secondary transition-colors' }}">
                                <span>{{ $category->nama_kategori }}</span>
                                <span class="w-1.5 h-1.5 rounded-full {{ request('category') == $category->id ? 'bg-primary' : 'bg-transparent group-hover:bg-secondary/20' }}"></span>
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </div>

                {{-- Status Info --}}
                <div class="pt-12 border-t border-secondary/10 space-y-4">
                    <p class="text-[9px] font-black uppercase tracking-[0.3em] text-secondary/20">Kurasi Saat Ini</p>
                    <p class="text-xs text-secondary/60 leading-relaxed italic">
                        Setiap produk kami dikurasi dengan cermat untuk memastikan kualitas terbaik sampai di tangan Anda.
                    </p>
                </div>
            </div>
        </aside>

        {{-- RIGHT: Product Grid --}}
        <div class="col-span-12 md:col-span-9">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3">
                @forelse($products as $product)
                <div class="group border-b border-r border-secondary/20 hover:bg-secondary/5 transition-colors duration-500">
                    {{-- Image Area --}}
                    <a href="{{ route('products.show', $product) }}" class="block aspect-[3/4] overflow-hidden relative grayscale hover:grayscale-0 transition-all duration-700">
                        <img class="w-full h-full object-cover transition-transform duration-1000 group-hover:scale-110" 
                             src="{{ $product->foto ? asset('storage/'.$product->foto) : 'https://ui-avatars.com/api/?name='.urlencode($product->nama_produk).'&background=FAFAE3&color=D9B2A9&size=512' }}" 
                             alt="{{ $product->nama_produk }}">
                        
                        {{-- Quick Info Overlay --}}
                        <div class="absolute inset-0 bg-secondary/80 opacity-0 group-hover:opacity-10 transition-opacity duration-500"></div>
                        
                        @if($product->stok <= 0)
                        <div class="absolute inset-0 flex items-center justify-center bg-background/80 backdrop-blur-sm px-6 text-center">
                            <span class="text-[10px] font-black uppercase tracking-[0.4em] text-secondary border border-secondary px-4 py-2">HABISt</span>
                        </div>
                        @endif
                    </a>

                    {{-- Content Area --}}
                    <div class="p-8 space-y-6">
                        <div class="space-y-2">
                            <div class="flex justify-between items-start gap-4">
                                <h3 class="font-headline text-2xl text-secondary leading-tight">
                                    <a href="{{ route('products.show', $product) }}">{{ $product->nama_produk }}</a>
                                </h3>
                                @auth
                                <form action="{{ route('wishlist.toggle', $product) }}" method="POST">
                                    @csrf
                                    @php $isWishlisted = \App\Models\Wishlist::where('user_id', Auth::id())->where('product_id', $product->id)->exists(); @endphp
                                    <button type="submit" class="text-secondary/30 hover:text-primary transition-colors">
                                        <span class="material-symbols-outlined text-sm" style="font-variation-settings: 'FILL' {{ $isWishlisted ? '1' : '0' }}">favorite</span>
                                    </button>
                                </form>
                                @endauth
                            </div>
                            <p class="text-[10px] font-black uppercase tracking-[0.2em] text-primary">
                                {{ $product->category->nama_kategori ?? 'UNSORTED' }}
                            </p>
                        </div>

                        <div class="flex items-baseline justify-between border-t border-secondary/10 pt-4">
                            <p class="font-headline text-lg text-secondary/80 font-bold">
                                Rp {{ number_format($product->harga, 0, ',', '.') }}
                            </p>
                            <form action="{{ route('cart.add', $product) }}" method="POST">
                                @csrf
                                <button type="submit" @disabled($product->stok <= 0) 
                                        class="text-[9px] font-black uppercase tracking-widest text-secondary hover:text-primary disabled:opacity-20 transition-colors">
                                    BELI +
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-span-full py-40 border-b border-secondary/20 text-center space-y-6">
                    <p class="font-headline text-3xl text-secondary opacity-20 italic">Produk Tidak Ditemukan</p>
                    <a href="{{ route('products.index') }}" class="inline-block text-[10px] font-black uppercase tracking-[0.3em] text-primary border-b border-primary pb-1">Reset Search</a>
                </div>
                @endforelse
            </div>

            {{-- Pagination --}}
            <div class="border-b border-secondary/20">
                <div class="p-8 md:p-16 flex justify-center">
                    {{ $products->links('vendor.pagination.simple-editorial') }}
                </div>
            </div>
        </div>
    </div>
</div>

<div class="w-full border-t border-secondary/20 mt-8"></div>

@endsection
