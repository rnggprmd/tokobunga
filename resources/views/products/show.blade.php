@extends('layouts.front')

@section('title', $product->nama_produk . ' — Mbah Bibit')

@section('content')

{{-- === TOP RULE === --}}
<div class="w-full border-t border-secondary/20"></div>

<div class="max-w-screen-xl mx-auto min-h-screen">
    <div class="grid grid-cols-12 border-b border-secondary/20 min-h-screen">
        
        {{-- LEFT: Visual Section --}}
        <div class="col-span-12 lg:col-span-7 border-b lg:border-b-0 lg:border-r border-secondary/20">
            {{-- Main Image --}}
            <div class="sticky top-24 p-8 md:p-16">
                <div class="aspect-[4/5] overflow-hidden grayscale hover:grayscale-0 transition-all duration-1000 group">
                    <img class="w-full h-full object-cover transition-transform duration-[2000ms] group-hover:scale-105" 
                         src="{{ $product->foto ? asset('storage/'.$product->foto) : 'https://ui-avatars.com/api/?name='.urlencode($product->nama_produk).'&background=FAFAE3&color=D9B2A9&size=1024' }}" 
                         alt="{{ $product->nama_produk }}">
                </div>

                {{-- Gallery --}}
                @if($product->gallery && is_array($product->gallery) && count($product->gallery) > 0)
                <div class="mt-8 grid grid-cols-4 gap-4">
                    @foreach($product->gallery as $image)
                    <div class="aspect-square overflow-hidden border border-secondary/10 opacity-40 hover:opacity-100 transition-opacity cursor-pointer">
                        <img class="w-full h-full object-cover grayscale hover:grayscale-0 transition-all" src="{{ asset('storage/'.$image) }}">
                    </div>
                    @endforeach
                </div>
                @endif
            </div>
        </div>

        {{-- RIGHT: Information Section --}}
        <div class="col-span-12 lg:col-span-5 flex flex-col">
            
            {{-- Breadcrumb & Category --}}
            <div class="px-8 md:px-12 py-6 border-b border-secondary/20 flex items-center justify-between">
                <div class="flex items-center gap-3 text-[9px] font-black uppercase tracking-[0.3em] text-secondary/40">
                    <a href="{{ route('home') }}" class="hover:text-primary transition-colors">Home</a>
                    <span>/</span>
                    <a href="{{ route('products.index', ['category' => $product->category_id]) }}" class="hover:text-primary transition-colors">{{ $product->category->nama_kategori ?? 'UMUM' }}</a>
                </div>
            </div>

            {{-- Headline --}}
            <div class="px-8 md:px-12 py-12 md:py-20 border-b border-secondary/20">
                <h1 class="font-headline text-[clamp(2.5rem,6vw,5rem)] text-secondary leading-[0.9] tracking-tight mb-8">
                    {{ $product->nama_produk }}
                </h1>
                <p class="font-headline text-3xl text-primary serif-italic">
                    Rp {{ number_format($product->harga, 0, ',', '.') }}
                </p>
            </div>

            {{-- Actions Grid --}}
            <div class="grid grid-cols-2 border-b border-secondary/20">
                {{-- Status --}}
                <div class="p-8 border-r border-secondary/20">
                    <p class="text-[9px] font-black uppercase tracking-[0.2em] text-secondary/30 mb-2">Ketersediaan</p>
                    @if($product->stok > 0)
                        <p class="text-sm font-bold text-secondary flex items-center gap-2">
                            <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full"></span>
                            {{ $product->stok }} Tersedia
                        </p>
                    @else
                        <p class="text-sm font-bold text-red-400 flex items-center gap-2">
                            <span class="w-1.5 h-1.5 bg-red-400 rounded-full"></span>
                            Stok Habis
                        </p>
                    @endif
                </div>
                {{-- Shared --}}
                <div class="p-8 flex items-center justify-between">
                    <div>
                        <p class="text-[9px] font-black uppercase tracking-[0.2em] text-secondary/30 mb-2">Kondisi</p>
                        <p class="text-sm font-bold text-secondary">Baru · Original</p>
                    </div>
                </div>
            </div>

            {{-- Form Section --}}
            <div class="p-8 md:px-12 border-b border-secondary/20 space-y-6">
                <form action="{{ route('cart.add', $product) }}" method="POST">
                    @csrf
                    <div class="flex items-center gap-6">
                        {{-- Quantity --}}
                        <div class="w-32 flex items-center border border-secondary/20 p-4 justify-between group focus-within:border-secondary transition-colors">
                            <button type="button" onclick="const i = this.nextElementSibling; i.value = Math.max(1, parseInt(i.value)-1)" class="text-secondary/40 hover:text-primary transition-colors">–</button>
                            <input type="text" value="1" readonly class="bg-transparent border-none p-0 w-8 text-center text-sm font-black text-secondary">
                            <button type="button" onclick="const i = this.previousElementSibling; i.value = parseInt(i.value)+1" class="text-secondary/40 hover:text-primary transition-colors">+</button>
                        </div>
                        {{-- Add to Cart --}}
                        <button type="submit" @disabled($product->stok <= 0) 
                                class="flex-1 bg-secondary text-[#FAFAE3] py-4 uppercase tracking-[0.2em] text-[11px] font-black hover:bg-primary transition-all disabled:opacity-20 disabled:grayscale">
                            Tambah ke Keranjang
                        </button>
                    </div>
                </form>

                @auth
                <form action="{{ route('wishlist.toggle', $product) }}" method="POST">
                    @csrf
                    @php $isWishlisted = \App\Models\Wishlist::where('user_id', Auth::id())->where('product_id', $product->id)->exists(); @endphp
                    <button type="submit" class="w-full border border-secondary/15 py-4 uppercase tracking-[0.2em] text-[10px] font-black text-secondary/60 hover:text-primary hover:border-primary transition-all flex items-center justify-center gap-3">
                        {{ $isWishlisted ? 'Hapus dari Favorit' : 'Tambah ke Favorit' }}
                    </button>
                </form>
                @endauth
            </div>

            {{-- Description --}}
            <div class="px-8 md:px-12 py-12 flex-1 space-y-8">
                <div class="space-y-4">
                    <p class="text-[9px] font-black uppercase tracking-[0.3em] text-secondary/30">Deskripsi Produk</p>
                    <div class="text-secondary/70 leading-[2] text-[14px] font-sans prose prose-sm">
                        {{ $product->deskripsi }}
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-8 pt-8 border-t border-secondary/10">
                    <div class="space-y-2">
                        <div class="flex items-center gap-2 text-secondary">
                            <span class="material-symbols-outlined text-sm">local_shipping</span>
                            <span class="text-[10px] font-black uppercase tracking-widest leading-none">Pengiriman Instan</span>
                        </div>
                        <p class="text-[11px] text-secondary/50 leading-relaxed">Pengiriman cepat untuk wilayah Madiun dan sekitarnya.</p>
                    </div>
                    <div class="space-y-2">
                        <div class="flex items-center gap-2 text-secondary">
                            <span class="material-symbols-outlined text-sm">verified</span>
                            <span class="text-[10px] font-black uppercase tracking-widest leading-none">Kualitas Terjamin</span>
                        </div>
                        <p class="text-[11px] text-secondary/50 leading-relaxed">Produk dipilih dan disiapkan secara saksama oleh tim kami.</p>
                    </div>
                </div>
            </div>

            {{-- Studio Signature --}}
            <div class="border-t border-secondary/20 px-8 md:px-12 py-6">
                <p class="text-[9px] text-secondary/40 uppercase tracking-[0.4em] text-center">Toko Bunga Mbah Bibit · Est. 1978</p>
            </div>
        </div>
    </div>

    {{-- === COMMUNITY REVIEWS === --}}
    <section class="border-b border-secondary/20">
        <div class="px-8 md:px-12 py-6 border-b border-secondary/20 flex items-center justify-between bg-secondary/[0.02]">
            <p class="text-[9px] font-black uppercase tracking-[0.3em] text-secondary/40">Ulasan Pelanggan</p>
            <p class="text-[9px] font-black uppercase tracking-[0.3em] text-secondary/40">{{ $product->reviews->count() }} Ulasan</p>
        </div>

        @if($product->reviews->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3">
            @foreach($product->reviews as $review)
            <div class="p-8 md:p-12 border-r border-b lg:border-b-0 last:border-r-0 border-secondary/15 flex flex-col justify-between space-y-8">
                <div class="space-y-6">
                    {{-- Rating --}}
                    <div class="flex gap-1">
                        @for($i = 1; $i <= 5; $i++)
                        <span class="material-symbols-outlined text-[12px] {{ $i <= $review->rating ? 'text-primary' : 'text-secondary/10' }}" style="font-variation-settings: 'FILL' 1">
                            star
                        </span>
                        @endfor
                    </div>
                    {{-- Comment --}}
                    <blockquote class="font-headline text-xl text-secondary leading-relaxed italic">
                        "{{ $review->comment }}"
                    </blockquote>
                </div>

                {{-- Author --}}
                <div class="flex items-center gap-4 pt-6 border-t border-secondary/10">
                    <div class="w-8 h-8 rounded-full bg-secondary/5 border border-secondary/10 flex items-center justify-center text-[10px] font-black text-secondary">
                        {{ substr($review->user->name, 0, 1) }}
                    </div>
                    <div>
                        <p class="text-[10px] font-black uppercase tracking-widest text-secondary">{{ $review->user->name }}</p>
                        <p class="text-[8px] text-secondary/40 uppercase tracking-widest">{{ $review->created_at->translatedFormat('d M Y') }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="py-24 text-center">
            <p class="font-headline text-2xl text-secondary/20 italic">Belum ada ulasan untuk produk ini.</p>
        </div>
        @endif
    </section>

    {{-- === RELATED PRODUCTS === --}}
    @if($relatedProducts->count() > 0)
    <section class="border-b border-secondary/20">
        <div class="px-8 md:px-12 py-6 border-b border-secondary/20 flex items-center justify-between">
            <p class="text-[9px] font-black uppercase tracking-[0.3em] text-secondary/40">Produk Serupa</p>
            <a href="{{ route('products.index') }}" class="text-[9px] font-black uppercase tracking-widest text-primary border-b border-primary pb-px">Lihat Katalog —</a>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4">
            @foreach($relatedProducts as $related)
            <div class="group border-r border-secondary/20 last:border-r-0 hover:bg-secondary/5 transition-colors duration-500">
                <a href="{{ route('products.show', $related) }}" class="block aspect-[3/4] overflow-hidden grayscale hover:grayscale-0 transition-all duration-700 relative">
                    <img class="w-full h-full object-cover transition-transform duration-1000 group-hover:scale-110" 
                         src="{{ $related->foto ? asset('storage/'.$related->foto) : 'https://ui-avatars.com/api/?name='.urlencode($related->nama_produk).'&background=FAFAE3&color=D9B2A9&size=512' }}">
                </a>
                <div class="p-8 space-y-4">
                    <div>
                        <p class="text-[8px] font-black uppercase tracking-[0.2em] text-primary mb-1">{{ $related->category->nama_kategori }}</p>
                        <h4 class="font-headline text-xl text-secondary group-hover:text-primary transition-colors">
                            <a href="{{ route('products.show', $related) }}">{{ $related->nama_produk }}</a>
                        </h4>
                    </div>
                    <p class="font-headline text-base text-secondary/80 font-bold pt-2 border-t border-secondary/10">
                        Rp {{ number_format($related->harga, 0, ',', '.') }}
                    </p>
                </div>
            </div>
            @endforeach
        </div>
    </section>
    @endif
</div>

<div class="w-full border-t border-secondary/20 mt-8"></div>

@endsection
