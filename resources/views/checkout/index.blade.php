@extends('layouts.front')

@section('title', 'Checkout — Mbah Bibit')

@section('content')

{{-- === TOP RULE === --}}
<div class="w-full border-t border-secondary/20"></div>

<div class="max-w-screen-xl mx-auto min-h-screen">
    
    {{-- === MASTHEAD === --}}
    <div class="grid grid-cols-12 border-b border-secondary/20">
        {{-- Label col --}}
        <div class="col-span-12 md:col-span-3 border-b md:border-b-0 md:border-r border-secondary/20 px-8 py-6 flex items-center">
            <div>
                <p class="text-[9px] font-black uppercase tracking-[0.3em] text-secondary/40">Pembayaran Aman</p>
                <p class="text-[9px] font-black uppercase tracking-[0.3em] text-secondary/40 mt-0.5">Konfirmasi Pesanan</p>
            </div>
        </div>
        {{-- Headline col --}}
        <div class="col-span-12 md:col-span-9 px-8 md:px-16 py-12 flex flex-col md:flex-row md:items-end justify-between gap-8">
            <h1 class="font-headline text-[clamp(3rem,8vw,6rem)] text-secondary leading-none tracking-tight">
                Selesaikan<br><span class="serif-italic text-primary">Pesanan</span>
            </h1>
            
            <a href="{{ route('cart.index') }}" class="text-[10px] font-black uppercase tracking-[0.3em] text-primary border-b border-primary pb-px mb-2">
                Kembali ke Keranjang —
            </a>
        </div>
    </div>

    {{-- === BODY === --}}
    <form action="{{ route('checkout.store') }}" method="POST" class="grid grid-cols-12 min-h-[60vh]">
        @csrf
        
        {{-- LEFT: Shipping Form --}}
        <div class="col-span-12 lg:col-span-8 border-b lg:border-b-0 md:border-r border-secondary/20">
            <div class="px-8 md:px-16 py-12 space-y-0">
                
                {{-- Field 1: Nama --}}
                <div class="py-8 border-b border-secondary/15 group focus-within:border-secondary/50 transition-colors">
                    <label class="block text-[9px] font-black uppercase tracking-[0.3em] text-secondary/30 mb-3 group-focus-within:text-secondary/60 transition-colors">Nama Penerima</label>
                    <input type="text" name="customer_name" required value="{{ auth()->user()->name ?? '' }}" autocomplete="off"
                           class="w-full bg-transparent border-none p-0 text-2xl md:text-3xl font-headline text-secondary placeholder:text-secondary/15 focus:ring-0 focus:outline-none"
                           placeholder="Nama Lengkap Penerima">
                </div>

                {{-- Field 2: WhatsApp --}}
                <div class="py-8 border-b border-secondary/15 group focus-within:border-secondary/50 transition-colors">
                    <label class="block text-[9px] font-black uppercase tracking-[0.3em] text-secondary/30 mb-3 group-focus-within:text-secondary/60 transition-colors">Nomor WhatsApp Aktif</label>
                    <input type="text" name="customer_phone" required value="{{ auth()->user()->phone ?? '' }}" autocomplete="off"
                           class="w-full bg-transparent border-none p-0 text-2xl md:text-3xl font-headline text-secondary placeholder:text-secondary/15 focus:ring-0 focus:outline-none"
                           placeholder="0812 ···">
                </div>

                {{-- Field 3: Alamat --}}
                <div class="py-12 border-b border-secondary/15 group focus-within:border-secondary/50 transition-colors">
                    <label class="block text-[9px] font-black uppercase tracking-[0.3em] text-secondary/30 mb-5 group-focus-within:text-secondary/60 transition-colors">Alamat Lengkap Pengiriman</label>
                    <textarea name="alamat_pengiriman" required rows="5"
                              class="w-full bg-transparent border-none p-0 text-base text-secondary/80 placeholder:text-secondary/15 focus:ring-0 focus:outline-none resize-none leading-relaxed"
                              placeholder="Cantumkan nama jalan, nomor rumah, kelurahan, kecamatan, dan kode pos tujuan pengiriman..."></textarea>
                    <div class="mt-8 flex items-center gap-3 opacity-30">
                        <span class="material-symbols-outlined text-sm">info</span>
                        <p class="text-[10px] font-bold uppercase tracking-widest leading-none">Pengiriman gratis untuk area Madiun & Sekitarnya</p>
                    </div>
                </div>

                {{-- Terms Info --}}
                <div class="pt-12">
                    <p class="text-[10px] text-secondary/40 uppercase tracking-widest leading-relaxed max-w-sm italic">
                        Dengan menekan tombol "Buat Pesanan", Anda menyetujui ketentuan pemesanan dan pengiriman Toko Bunga Mbah Bibit.
                    </p>
                </div>
            </div>
        </div>

        {{-- RIGHT: Summary Column --}}
        <div class="col-span-12 lg:col-span-4 flex flex-col">
            <div class="p-12 space-y-12 flex-1">
                <div class="space-y-6">
                    <p class="text-[9px] font-black uppercase tracking-[0.3em] text-secondary/30">Ringkasan Pesanan</p>
                    
                    <div class="space-y-4 pt-6 border-t border-secondary/15 text-sm">
                        <div class="flex justify-between items-baseline">
                            <span class="text-secondary/50 font-bold uppercase tracking-widest text-[10px]">Item Terpilih</span>
                            <span class="text-secondary font-headline text-lg italic tracking-widest">{{ count($cart) }} Produk</span>
                        </div>
                        <div class="flex justify-between items-baseline">
                            <span class="text-secondary/50 font-bold uppercase tracking-widest text-[10px]">Subtotal</span>
                            <span class="text-secondary font-headline text-lg tracking-widest">Rp {{ number_format($total, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between items-baseline">
                            <span class="text-secondary/50 font-bold uppercase tracking-widest text-[10px]">Logistik</span>
                            <span class="text-emerald-700 font-headline text-lg italic tracking-widest shrink-0 underline decoration-1 underline-offset-4">Gratis</span>
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
                        <button type="submit"
                                class="group w-full bg-secondary text-[#FAFAE3] py-6 uppercase tracking-[0.3em] text-[11px] font-black hover:bg-primary transition-all text-center flex items-center justify-center gap-4">
                            Buat Pesanan Sekarang
                            <span class="material-symbols-outlined text-lg transition-transform group-hover:translate-x-1">verified</span>
                        </button>
                        <div class="flex items-center gap-2 justify-center opacity-20 group">
                            <span class="material-symbols-outlined text-xs">shield</span>
                            <p class="text-[9px] font-bold uppercase tracking-[0.2em] italic">Sistem Pembayaran Aman Mbah Bibit</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="border-t border-secondary/20 px-12 py-6 bg-secondary/[0.01]">
                <p class="text-[9px] text-secondary/40 uppercase tracking-[0.4em] text-center">Toko Bunga Mbah Bibit · Est. 1978</p>
            </div>
        </div>
    </form>
</div>

<div class="w-full border-t border-secondary/20 mt-8"></div>

@endsection
