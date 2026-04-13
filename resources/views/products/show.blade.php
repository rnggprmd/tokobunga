@extends('layouts.front')

@section('title', $product->nama_produk . ' - Mbah Bibit')

@section('content')
<div class="max-w-screen-2xl mx-auto px-6 py-12">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-16">
        <!-- Image Section -->
        <div class="lg:col-span-7 space-y-4">
            <div class="aspect-square rounded-[3rem] overflow-hidden bg-surface shadow-2xl border border-primary/10">
                <img class="w-full h-full object-cover" 
                     src="{{ $product->foto ? asset('storage/'.$product->foto) : 'https://ui-avatars.com/api/?name='.urlencode($product->nama_produk).'&background=FAFAE3&color=D9B2A9&size=1024' }}" 
                     alt="{{ $product->nama_produk }}">
            </div>
            
            {{-- In a real app, I'd loop through product gallery images here --}}
            <div class="grid grid-cols-4 gap-4">
                @for($i=0; $i<4; $i++)
                <div class="aspect-square rounded-2xl bg-surface border border-primary/10 opacity-50 hover:opacity-100 transition-opacity cursor-pointer overflow-hidden">
                    <img class="w-full h-full object-cover grayscale hover:grayscale-0 transition-all" src="{{ $product->foto ? asset('storage/'.$product->foto) : 'https://ui-avatars.com/api/?name='.$i.'&background=FAFAE3&color=D9B2A9' }}">
                </div>
                @endfor
            </div>
        </div>

        <!-- Info Section -->
        <div class="lg:col-span-5 space-y-8">
            <div class="space-y-4">
                <nav class="flex gap-2 text-xs font-bold uppercase tracking-widest text-secondary/60">
                    <a href="{{ route('home') }}" class="hover:text-primary">Mbah Bibit</a>
                    <span>/</span>
                    <a href="{{ route('products.index', ['category' => $product->category_id]) }}" class="hover:text-primary">{{ $product->category->nama_kategori ?? 'UMUM' }}</a>
                </nav>
                
                <h1 class="font-headline text-5xl md:text-6xl text-secondary leading-tight">{{ $product->nama_produk }}</h1>
                
                <div class="flex items-center gap-4">
                    <span class="font-headline text-3xl text-primary font-bold">Rp {{ number_format($product->harga, 0, ',', '.') }}</span>
                    <span class="bg-primary/10 text-primary px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-widest">{{ $product->tipe_produk }}</span>
                </div>
            </div>

            <div class="p-6 bg-surface rounded-3xl border border-primary/10 space-y-6">
                <div class="flex items-center justify-between">
                    <div class="space-y-1">
                        <p class="text-[10px] font-bold uppercase tracking-widest text-secondary/60">Status Stok</p>
                        @if($product->stok > 0)
                        <div class="flex items-center gap-2 text-green-600 font-bold">
                            <span class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></span>
                            {{ $product->stok }} Tersedia
                        </div>
                        @else
                        <div class="flex items-center gap-2 text-red-500 font-bold font-sans">
                            <span class="w-2 h-2 bg-red-500 rounded-full"></span>
                            Out of Stock
                        </div>
                        @endif
                    </div>
                    <div class="h-10 w-[1px] bg-primary/20"></div>
                    <div class="space-y-1">
                        <p class="text-[10px] font-bold uppercase tracking-widest text-secondary/60">Terjual</p>
                        <p class="font-bold text-secondary">0+ Koleksi</p>
                    </div>
                </div>

                <form action="{{ route('cart.add', $product) }}" method="POST" class="space-y-4">
                    @csrf
                    <div class="flex gap-4">
                        <div class="w-24 flex items-center bg-background border border-primary/20 rounded-full px-2 overflow-hidden">
                            <button type="button" class="p-2 text-secondary hover:text-primary">-</button>
                            <input type="text" value="1" readonly class="w-full text-center bg-transparent border-none text-sm font-bold p-0">
                            <button type="button" class="p-2 text-secondary hover:text-primary">+</button>
                        </div>
                        <button type="submit" @disabled($product->stok <= 0) class="flex-1 bg-primary text-white py-4 rounded-full font-bold text-sm uppercase tracking-widest hover:shadow-xl hover:shadow-primary/20 transition-all disabled:opacity-50 disabled:cursor-not-allowed">
                            Tambah ke Keranjang
                        </button>
                    </div>
                    <button type="button" class="w-full border border-primary/30 text-primary py-4 rounded-full font-bold text-sm uppercase tracking-widest hover:bg-primary/5 transition-all">
                        Beli Sekarang
                    </button>
                </form>
            </div>

            <div class="space-y-6">
                <div>
                    <h3 class="font-headline text-2xl text-secondary mb-2 border-b border-primary/10 pb-2">Deskripsi Specimen</h3>
                    <p class="text-on-surface-variant leading-relaxed text-sm">
                        {{ $product->deskripsi }}
                    </p>
                </div>
                
                <div class="grid grid-cols-2 gap-4">
                    <div class="flex items-center gap-3 p-4 bg-surface rounded-2xl border border-primary/5">
                        <span class="material-symbols-outlined text-primary">local_shipping</span>
                        <div class="text-[10px]">
                            <p class="font-bold text-secondary uppercase">Pengiriman Cepat</p>
                            <p class="text-secondary/60">Solo & Sekitarnya 1-2 Jam</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3 p-4 bg-surface rounded-2xl border border-primary/5">
                        <span class="material-symbols-outlined text-primary">verified</span>
                        <div class="text-[10px]">
                            <p class="font-bold text-secondary uppercase">Dijamin Segar</p>
                            <p class="text-secondary/60">Pilihan Terbaik Mbah Bibit</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Related Products -->
    @if($relatedProducts->count() > 0)
    <section class="mt-24 space-y-12">
        <h2 class="font-headline text-4xl text-on-surface border-b border-primary/20 pb-4">Koleksi Terkait</h2>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            @foreach($relatedProducts as $related)
            <div class="group bg-surface rounded-3xl overflow-hidden border border-primary/10">
                <a href="{{ route('products.show', $related) }}" class="block aspect-[4/5] overflow-hidden">
                    <img class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110" 
                         src="{{ $related->foto ? asset('storage/'.$related->foto) : 'https://ui-avatars.com/api/?name='.urlencode($related->nama_produk).'&background=FAFAE3&color=D9B2A9&size=512' }}">
                </a>
                <div class="p-6">
                    <p class="text-[8px] font-black uppercase tracking-widest text-primary mb-1">{{ $related->category->nama_kategori }}</p>
                    <h4 class="font-headline text-lg group-hover:text-primary transition-colors">
                        <a href="{{ route('products.show', $related) }}">{{ $related->nama_produk }}</a>
                    </h4>
                </div>
            </div>
            @endforeach
        </div>
    </section>
    @endif
</div>
@endsection
