@extends('layouts.front')

@section('title', 'Tas Belanja — Mbah Bibit')

@section('content')

{{-- === TOP RULE === --}}
<div class="w-full border-t border-secondary/20"></div>

<div class="max-w-screen-xl mx-auto min-h-screen">
    
    {{-- === MASTHEAD === --}}
    <div class="grid grid-cols-12 border-b border-secondary/20">
        {{-- Label col --}}
        <div class="col-span-12 md:col-span-3 border-b md:border-b-0 md:border-r border-secondary/20 px-8 py-6 flex items-center">
            <div>
                <p class="text-[9px] font-black uppercase tracking-[0.3em] text-secondary/40">Mbah Bibit Studio</p>
                <p class="text-[9px] font-black uppercase tracking-[0.3em] text-secondary/40 mt-0.5">Seleksi Item</p>
            </div>
        </div>
        {{-- Headline col --}}
        <div class="col-span-12 md:col-span-9 px-8 md:px-16 py-12 flex flex-col md:flex-row md:items-end justify-between gap-8">
            <h1 class="font-headline text-[clamp(3rem,8vw,6rem)] text-secondary leading-none tracking-tight">
                Tas<br><span class="serif-italic text-primary">Belanja</span>
            </h1>
            
            <a href="{{ route('products.index') }}" class="text-[10px] font-black uppercase tracking-[0.3em] text-primary border-b border-primary pb-px mb-2">
                Lanjut Belanja —
            </a>
        </div>
    </div>

    {{-- === BODY === --}}
    @if(count($cart) > 0)
    <div class="grid grid-cols-12 min-h-[60vh]">
        
        {{-- LEFT: Items Table --}}
        <div class="col-span-12 lg:col-span-8 border-b lg:border-b-0 md:border-r border-secondary/20">
            <div class="grid grid-cols-1">
                {{-- Table Header --}}
                <div class="grid grid-cols-12 border-b border-secondary/20 px-8 py-4 bg-secondary/[0.02]">
                    <div class="col-span-6 md:col-span-7">
                        <p class="text-[9px] font-black uppercase tracking-widest text-secondary/30">Produk</p>
                    </div>
                    <div class="col-span-4 md:col-span-3 text-center">
                        <p class="text-[9px] font-black uppercase tracking-widest text-secondary/30">Jumlah</p>
                    </div>
                    <div class="col-span-2 text-right">
                        <p class="text-[9px] font-black uppercase tracking-widest text-secondary/30">Total</p>
                    </div>
                </div>

                {{-- Item Rows --}}
                @foreach($cart as $id => $item)
                <div class="grid grid-cols-12 border-b border-secondary/15 px-8 py-10 group items-center last:border-b-0">
                    {{-- Info --}}
                    <div class="col-span-12 md:col-span-7 flex gap-8 items-center mb-6 md:mb-0">
                        <div class="w-24 aspect-square overflow-hidden border border-secondary/10 grayscale group-hover:grayscale-0 transition-all duration-700">
                            <img class="w-full h-full object-cover" src="{{ $item['foto'] ? asset('storage/'.$item['foto']) : 'https://ui-avatars.com/api/?name='.urlencode($item['nama']).'&background=FAFAE3&color=D9B2A9' }}">
                        </div>
                        <div class="space-y-1">
                            <h3 class="font-headline text-2xl text-secondary group-hover:text-primary transition-colors">{{ $item['nama'] }}</h3>
                            <p class="text-xs text-secondary/50">Harga Satuan: Rp {{ number_format($item['harga'], 0, ',', '.') }}</p>
                        </div>
                    </div>

                    {{-- Qty --}}
                    <div class="col-span-6 md:col-span-3 flex justify-center">
                        <div class="flex items-center border border-secondary/20 px-4 py-2 gap-6 bg-background">
                            <button class="text-secondary/30 hover:text-primary transition-colors">—</button>
                            <span class="text-xs font-black text-secondary">{{ $item['quantity'] }}</span>
                            <button class="text-secondary/30 hover:text-primary transition-colors">+</button>
                        </div>
                    </div>

                    {{-- Total & Remove --}}
                    <div class="col-span-6 md:col-span-2 text-right space-y-2">
                        <p class="font-headline text-xl text-secondary">Rp {{ number_format($item['harga'] * $item['quantity'], 0, ',', '.') }}</p>
                        <form action="{{ route('cart.remove', $id) }}" method="POST">
                            @csrf
                            <button type="submit" class="text-[9px] font-black uppercase tracking-widest text-accent-rose/40 hover:text-accent-rose transition-colors">
                                Hapus Item
                            </button>
                        </form>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        {{-- RIGHT: Summary --}}
        <div class="col-span-12 lg:col-span-4 flex flex-col">
            <div class="p-12 space-y-12 flex-1">
                <div class="space-y-6">
                    <p class="text-[9px] font-black uppercase tracking-[0.3em] text-secondary/30">Ringkasan Tagihan</p>
                    
                    <div class="space-y-4 pt-6 border-t border-secondary/15 text-sm">
                        <div class="flex justify-between items-baseline">
                            <span class="text-secondary/50 font-bold uppercase tracking-widest text-[10px]">Total Item</span>
                            <span class="text-secondary font-headline text-lg italic tracking-widest">{{ count($cart) }}</span>
                        </div>
                        <div class="flex justify-between items-baseline">
                            <span class="text-secondary/50 font-bold uppercase tracking-widest text-[10px]">Subtotal</span>
                            <span class="text-secondary font-headline text-lg tracking-widest">Rp {{ number_format($total, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between items-baseline">
                            <span class="text-secondary/50 font-bold uppercase tracking-widest text-[10px]">Pengiriman</span>
                            <span class="text-emerald-700 font-headline text-lg italic tracking-widest italic shrink-0">Complimentary</span>
                        </div>
                    </div>
                </div>

                <div class="space-y-8">
                    <div class="pt-8 border-t border-secondary/30 flex justify-between items-end">
                        <p class="text-[10px] font-black uppercase tracking-[0.4em] text-secondary/40">Total Tagihan</p>
                        <div class="text-right">
                             <p class="font-headline text-[2.5rem] text-primary leading-none">
                                Rp {{ number_format($total, 0, ',', '.') }}
                             </p>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <a href="{{ route('checkout.index') }}" class="group block w-full bg-secondary text-[#FAFAE3] py-6 uppercase tracking-[0.3em] text-[11px] font-black hover:bg-primary transition-all text-center flex items-center justify-center gap-4">
                            Proceed to Checkout
                            <span class="material-symbols-outlined text-lg transition-transform group-hover:translate-x-1">arrow_forward</span>
                        </a>
                        <p class="text-center text-[9px] text-secondary/30 uppercase tracking-[0.2em] italic leading-relaxed">
                            Setiap pembelian include kartu ucapan<br>eksklusif Mbah Bibit.
                        </p>
                    </div>
                </div>
            </div>

            <div class="border-t border-secondary/20 px-12 py-6">
                <p class="text-[9px] text-secondary/40 uppercase tracking-[0.4em] text-center">Studio Selection Archiv · 1978</p>
            </div>
        </div>
    </div>
    @else
    <div class="py-40 text-center border-b border-secondary/20">
        <p class="font-headline text-3xl text-secondary/20 italic mb-8">Tas Belanja Anda Masih Kosong</p>
        <a href="{{ route('products.index') }}" class="inline-block bg-secondary text-[#FAFAE3] px-10 py-5 uppercase tracking-widest text-[11px] font-black hover:bg-primary transition-colors">
            Kembali ke Katalog
        </a>
    </div>
    @endif
</div>

<div class="w-full border-t border-secondary/20 mt-8"></div>

@endsection
