@extends('layouts.front')

@section('title', 'Keranjang Belanja - Mbah Bibit')

@section('content')
<div class="max-w-screen-2xl mx-auto px-6 py-12">
    <div class="space-y-12">
        <header class="flex justify-between items-end border-b border-primary/20 pb-6">
            <div class="space-y-2">
                <span class="font-label text-xs uppercase tracking-[0.3em] text-primary">Your Selection</span>
                <h1 class="font-headline text-5xl text-secondary">Keranjang Belanja</h1>
            </div>
            <a href="{{ route('products.index') }}" class="text-sm font-bold text-primary hover:underline flex items-center gap-2 mb-2">
                <span class="material-symbols-outlined text-sm">arrow_back</span>
                Lanjut Belanja
            </a>
        </header>

        @if(count($cart) > 0)
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-16">
            <!-- Items List -->
            <div class="lg:col-span-8 space-y-6">
                @foreach($cart as $id => $item)
                <div class="flex flex-col md:flex-row gap-6 p-6 bg-surface rounded-3xl border border-primary/10 items-center">
                    <div class="w-32 aspect-square rounded-2xl overflow-hidden bg-background">
                        <img class="w-full h-full object-cover" src="{{ $item['foto'] ? asset('storage/'.$item['foto']) : 'https://ui-avatars.com/api/?name='.urlencode($item['nama']).'&background=FAFAE3&color=D9B2A9' }}">
                    </div>
                    
                    <div class="flex-1 space-y-1 text-center md:text-left">
                        <h3 class="font-headline text-2xl text-secondary">{{ $item['nama'] }}</h3>
                        <p class="text-primary font-bold">Rp {{ number_format($item['harga'], 0, ',', '.') }}</p>
                    </div>

                    <div class="flex items-center gap-6">
                        <div class="flex items-center bg-background border border-primary/20 rounded-full px-2">
                            <button class="p-2 text-secondary hover:text-primary">-</button>
                            <span class="w-8 text-center text-sm font-bold">{{ $item['quantity'] }}</span>
                            <button class="p-2 text-secondary hover:text-primary">+</button>
                        </div>
                        
                        <div class="w-32 text-right hidden md:block">
                            <p class="text-xs text-secondary/60 uppercase font-black">Subtotal</p>
                            <p class="font-bold text-secondary">Rp {{ number_format($item['harga'] * $item['quantity'], 0, ',', '.') }}</p>
                        </div>

                        <form action="{{ route('cart.remove', $id) }}" method="POST">
                            @csrf
                            <button type="submit" class="p-2 text-secondary hover:text-red-500 transition-colors">
                                <span class="material-symbols-outlined">delete</span>
                            </button>
                        </form>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Summary -->
            <div class="lg:col-span-4">
                <div class="sticky top-32 p-8 bg-surface rounded-[3rem] border border-primary/20 space-y-8 shadow-xl">
                    <h3 class="font-headline text-3xl text-secondary">Ringkasan Pesanan</h3>
                    
                    <div class="space-y-4 pt-4 border-t border-primary/10">
                        <div class="flex justify-between text-sm">
                            <span class="text-secondary/60 uppercase font-bold tracking-widest text-[10px]">Total Item</span>
                            <span class="font-bold text-secondary">{{ count($cart) }} Produk</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-secondary/60 uppercase font-bold tracking-widest text-[10px]">Subtotal</span>
                            <span class="font-bold text-secondary">Rp {{ number_format($total, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-secondary/60 uppercase font-bold tracking-widest text-[10px]">Biaya Layanan</span>
                            <span class="font-bold text-green-600">Gratis</span>
                        </div>
                        
                        <div class="pt-6 border-t border-primary/20 flex justify-between items-end">
                            <span class="font-headline text-xl text-secondary">Total Tagihan</span>
                            <span class="font-headline text-3xl text-primary font-bold">Rp {{ number_format($total, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <button class="w-full bg-secondary text-white py-5 rounded-full font-bold text-sm uppercase tracking-widest hover:bg-primary transition-all shadow-xl shadow-secondary/10">
                        Lanjut ke Pembayaran
                    </button>
                    
                    <div class="flex items-center gap-2 justify-center opacity-40">
                        <span class="material-symbols-outlined text-sm">lock</span>
                        <p class="text-[10px] font-bold uppercase tracking-tighter">Secure Botanical Checkout</p>
                    </div>
                </div>
            </div>
        </div>
        @else
        <div class="py-40 text-center space-y-6">
            <div class="w-32 h-32 bg-surface rounded-full flex items-center justify-center mx-auto border border-primary/10">
                <span class="material-symbols-outlined text-6xl text-primary/30">shopping_bag</span>
            </div>
            <div class="space-y-2">
                <h3 class="font-headline text-3xl text-secondary">Wah, Keranjang Anda Kosong</h3>
                <p class="text-secondary/60 text-sm">Mari temukan bunga yang sempurna untuk Anda hari ini.</p>
            </div>
            <a href="{{ route('products.index') }}" class="inline-block bg-primary text-white px-8 py-4 rounded-full font-bold text-sm uppercase tracking-widest shadow-lg shadow-primary/20">
                Eksplor Katalog
            </a>
        </div>
        @endif
    </div>
</div>
@endsection
