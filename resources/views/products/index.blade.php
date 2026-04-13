@extends('layouts.front')

@section('title', 'Katalog Bunga - Mbah Bibit')

@section('content')
<div class="max-w-screen-2xl mx-auto px-6 py-12">
    <div class="flex flex-col md:flex-row gap-12">
        <!-- Sidebar Filters -->
        <aside class="w-full md:w-64 space-y-8">
            <div>
                <h3 class="font-headline text-2xl text-secondary mb-4 border-b border-primary/20 pb-2">Kategori</h3>
                <ul class="space-y-2">
                    <li>
                        <a href="{{ route('products.index') }}" class="block px-2 py-1 text-sm font-bold {{ !request('category') ? 'text-primary bg-primary/5 rounded-lg' : 'text-secondary hover:text-primary transition-colors' }}">
                            Semua Produk
                        </a>
                    </li>
                    @foreach($categories as $category)
                    <li>
                        <a href="{{ route('products.index', ['category' => $category->id]) }}" class="block px-2 py-1 text-sm font-bold {{ request('category') == $category->id ? 'text-primary bg-primary/5 rounded-lg' : 'text-secondary hover:text-primary transition-colors' }}">
                            {{ $category->nama_kategori }}
                        </a>
                    </li>
                    @endforeach
                </ul>
            </div>

            <div>
                <h3 class="font-headline text-2xl text-secondary mb-4 border-b border-primary/20 pb-2">Pencarian</h3>
                <form action="{{ route('products.index') }}" method="GET">
                    <div class="relative">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari bunga..." class="w-full bg-surface border-primary/20 rounded-xl text-sm focus:ring-primary focus:border-primary">
                        <button type="submit" class="absolute right-2 top-1.5 text-primary">
                            <span class="material-symbols-outlined text-xl">search</span>
                        </button>
                    </div>
                </form>
            </div>
        </aside>

        <!-- Product Grid -->
        <div class="flex-1 space-y-8">
            <header class="flex justify-between items-center bg-surface p-6 rounded-3xl border border-primary/10">
                <div>
                    <h1 class="font-headline text-3xl text-secondary">Katalog Specimen</h1>
                    <p class="text-xs text-secondary/60 uppercase tracking-[0.2em] mt-1">Menampilkan {{ $products->count() }} produk dari total {{ $products->total() }}</p>
                </div>
                <div class="flex gap-2">
                    {{-- Pagination info or sort could go here --}}
                </div>
            </header>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($products as $product)
                <div class="group bg-surface rounded-3xl overflow-hidden border border-primary/10 hover:shadow-2xl hover:shadow-primary/5 transition-all duration-500">
                    <a href="{{ route('products.show', $product) }}" class="block aspect-[4/5] overflow-hidden relative">
                        <img class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110" 
                             src="{{ $product->foto ? asset('storage/'.$product->foto) : 'https://ui-avatars.com/api/?name='.urlencode($product->nama_produk).'&background=FAFAE3&color=D9B2A9&size=512' }}" 
                             alt="{{ $product->nama_produk }}">
                        <div class="absolute top-4 right-4 bg-background px-3 py-1 rounded-full text-[10px] font-bold tracking-widest uppercase text-primary border border-primary/20 shadow-sm">
                            {{ $product->category->nama_kategori ?? 'UMUM' }}
                        </div>
                    </a>
                    <div class="p-6 space-y-4">
                        <div class="space-y-1">
                            <h3 class="font-headline text-xl text-secondary group-hover:text-primary transition-colors">
                                <a href="{{ route('products.show', $product) }}">{{ $product->nama_produk }}</a>
                            </h3>
                            <p class="text-primary font-headline text-lg font-bold">Rp {{ number_format($product->harga, 0, ',', '.') }}</p>
                        </div>
                        
                        <p class="text-xs text-on-surface-variant leading-relaxed line-clamp-2">{{ $product->deskripsi }}</p>
                        
                        <div class="pt-2 flex items-center justify-between gap-4">
                            <form action="{{ route('cart.add', $product) }}" method="POST" class="flex-1">
                                @csrf
                                <button type="submit" class="w-full bg-primary text-white py-2 rounded-full font-bold text-[10px] uppercase tracking-widest hover:opacity-90 transition-all flex items-center justify-center gap-2">
                                    <span class="material-symbols-outlined text-sm">shopping_bag</span>
                                    Tambah
                                </button>
                            </form>
                            <a href="#" class="p-2 border border-primary/20 rounded-full text-secondary hover:text-accent-rose hover:border-accent-rose transition-all">
                                <span class="material-symbols-outlined text-lg">favorite</span>
                            </a>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-span-full py-40 text-center space-y-4">
                    <span class="material-symbols-outlined text-6xl text-outline opacity-20">search_off</span>
                    <p class="text-secondary italic text-lg">Maaf, kami tidak menemukan produk yang sesuai pencarian Anda.</p>
                    <a href="{{ route('products.index') }}" class="inline-block text-primary font-bold hover:underline">Lihat Semua Produk</a>
                </div>
                @endforelse
            </div>

            <!-- Pagination -->
            <div class="pt-12">
                {{ $products->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
