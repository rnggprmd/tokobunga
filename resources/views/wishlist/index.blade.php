@extends('layouts.front')

@section('title', 'Wishlist Saya — Mbah Bibit')

@section('content')

{{-- === TOP RULE === --}}
<div class="w-full border-t border-secondary/20"></div>

<div class="max-w-screen-xl mx-auto min-h-screen">
    
    {{-- === MASTHEAD === --}}
    <div class="grid grid-cols-12 border-b border-secondary/20">
        {{-- Label col --}}
        <div class="col-span-12 md:col-span-3 border-b md:border-b-0 md:border-r border-secondary/20 px-8 py-6 flex items-center">
            <div>
                <p class="text-[9px] font-black uppercase tracking-[0.3em] text-secondary/40">User Archiv</p>
                <p class="text-[9px] font-black uppercase tracking-[0.3em] text-secondary/40 mt-0.5">Favorit Saya</p>
            </div>
        </div>
        {{-- Headline col --}}
        <div class="col-span-12 md:col-span-9 px-8 md:px-16 py-12 flex flex-col md:flex-row md:items-end justify-between gap-8">
            <h1 class="font-headline text-[clamp(3rem,8vw,6rem)] text-secondary leading-none tracking-tight">
                Koleksi<br><span class="serif-italic text-primary">Incurata</span>
            </h1>
            
            <a href="{{ route('products.index') }}" class="text-[10px] font-black uppercase tracking-[0.3em] text-primary border-b border-primary pb-px mb-2">
                Eksplor Katalog —
            </a>
        </div>
    </div>

    {{-- === BODY === --}}
    <div class="grid grid-cols-12">
        {{-- Side Info --}}
        <aside class="col-span-12 md:col-span-3 border-b md:border-b-0 md:border-r border-secondary/20 px-8 py-12">
            <div class="sticky top-24 space-y-8">
                <p class="text-secondary/60 leading-relaxed text-sm italic">
                    Daftar kurasi pribadi Anda. Simpan spesimen yang memikat hati untuk diproses kemudian.
                </p>
                <div class="pt-8 border-t border-secondary/10">
                    <p class="text-[9px] font-black uppercase tracking-widest text-secondary/30 mb-2">Jumlah Item</p>
                    <p class="text-2xl font-headline text-secondary">{{ $wishlistItems->count() }} Terpilih</p>
                </div>
            </div>
        </aside>

        {{-- Grid Area --}}
        <div class="col-span-12 md:col-span-9">
            @if($wishlistItems->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3">
                @foreach($wishlistItems as $item)
                @php $product = $item->product; @endphp
                <div class="group border-b border-r border-secondary/20 hover:bg-secondary/5 transition-all duration-500">
                    {{-- Image --}}
                    <div class="relative aspect-[3/4] overflow-hidden grayscale hover:grayscale-0 transition-all duration-700">
                        <a href="{{ route('products.show', $product) }}" class="block w-full h-full">
                            <img class="w-full h-full object-cover transition-transform duration-1000 group-hover:scale-110" 
                                 src="{{ $product->foto ? asset('storage/'.$product->foto) : 'https://ui-avatars.com/api/?name='.urlencode($product->nama_produk).'&background=FAFAE3&color=D9B2A9&size=512' }}">
                        </a>
                        
                        {{-- Remove button --}}
                        <form action="{{ route('wishlist.remove', $item) }}" method="POST" class="absolute top-4 right-4 translate-y-2 opacity-0 group-hover:translate-y-0 group-hover:opacity-100 transition-all duration-300">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-10 h-10 bg-background/90 backdrop-blur rounded-full flex items-center justify-center text-accent-rose hover:bg-accent-rose hover:text-background transition-all shadow-sm">
                                <span class="material-symbols-outlined text-sm">close</span>
                            </button>
                        </form>
                    </div>

                    {{-- Info --}}
                    <div class="p-8 space-y-6">
                        <div class="space-y-2">
                             <p class="text-[8px] font-black uppercase tracking-[0.2em] text-primary">{{ $product->category->nama_kategori ?? 'UMUM' }}</p>
                             <h3 class="font-headline text-2xl text-secondary group-hover:text-primary transition-colors">
                                 <a href="{{ route('products.show', $product) }}">{{ $product->nama_produk }}</a>
                             </h3>
                             <p class="text-primary font-headline text-lg font-bold">Rp {{ number_format($product->harga, 0, ',', '.') }}</p>
                        </div>

                        <div class="pt-6 border-t border-secondary/10">
                            <form action="{{ route('cart.add', $product) }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full bg-secondary text-[#FAFAE3] py-4 uppercase tracking-[0.2em] text-[10px] font-black hover:bg-primary transition-colors">
                                    Pindah ke Keranjang +
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="py-40 text-center border-b border-secondary/20">
                <p class="font-headline text-3xl text-secondary/20 italic mb-8">Belum Ada Koleksi Terpilih</p>
                <a href="{{ route('products.index') }}" class="inline-block bg-secondary text-[#FAFAE3] px-10 py-5 uppercase tracking-widest text-[11px] font-black hover:bg-primary transition-colors">
                    Kembali ke Katalog
                </a>
            </div>
            @endif
        </div>
    </div>
</div>

<div class="w-full border-t border-secondary/20 mt-8"></div>

@endsection
