@extends('layouts.front')

@section('title', 'Pembayaran Berhasil — Mbah Bibit')

@section('content')

{{-- === TOP RULE === --}}
<div class="w-full border-t border-secondary/20"></div>

<div class="max-w-screen-xl mx-auto min-h-screen">
    
    {{-- === MASTHEAD === --}}
    <div class="grid grid-cols-12 border-b border-secondary/20">
        {{-- Label col --}}
        <div class="col-span-12 md:col-span-3 border-b md:border-b-0 md:border-r border-secondary/20 px-8 py-6 flex items-center">
            <div>
                <p class="text-[9px] font-black uppercase tracking-[0.3em] text-secondary/40">Status Transaksi</p>
                <p class="text-[9px] font-black uppercase tracking-[0.3em] text-emerald-600/70 mt-0.5">Berhasil</p>
            </div>
        </div>
        {{-- Headline col --}}
        <div class="col-span-12 md:col-span-9 px-8 md:px-16 py-12 flex flex-col md:flex-row md:items-end justify-between gap-8">
            <h1 class="font-headline text-[clamp(2.5rem,6vw,4.5rem)] text-secondary leading-none tracking-tight">
                Pembayaran<br><span class="serif-italic text-emerald-600">Berhasil</span>
            </h1>
        </div>
    </div>

    {{-- === BODY === --}}
    <div class="grid grid-cols-12 min-h-[50vh]">
        
        {{-- LEFT: Info --}}
        <div class="col-span-12 lg:col-span-5 border-b lg:border-b-0 md:border-r border-secondary/20">
            <div class="p-8 md:p-12 space-y-12">
                <div class="space-y-6">
                    <span class="material-symbols-outlined text-6xl text-emerald-500 mb-4 block">check_circle</span>
                    <h2 class="text-2xl font-bold text-secondary">Terima Kasih, {{ $order->customer_name }}!</h2>
                    <p class="text-sm text-secondary/70 leading-relaxed">
                        Pembayaran Anda untuk pesanan <strong>#ORD-{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</strong> telah berhasil diverifikasi oleh sistem. 
                        Tim botanikal kami akan segera mempersiapkan pesanan Anda.
                    </p>
                </div>
            </div>
        </div>

        {{-- RIGHT: Actions --}}
        <div class="col-span-12 lg:col-span-7 flex flex-col justify-center items-center p-12 md:p-24 space-y-8 bg-secondary/[0.02]">
            
            <div class="w-full max-w-sm space-y-4">
                <a href="{{ route('invoice.show', $order->id) }}" class="group w-full bg-secondary text-[#FAFAE3] py-5 uppercase tracking-[0.2em] text-[11px] font-black hover:bg-primary transition-all text-center flex items-center justify-center gap-3">
                    <span class="material-symbols-outlined text-base">receipt_long</span>
                    Lihat Invoice
                </a>

                <a href="{{ route('invoice.download', $order->id) }}" class="group w-full bg-transparent border border-secondary/30 text-secondary py-5 uppercase tracking-[0.2em] text-[11px] font-black hover:bg-secondary/5 transition-all text-center flex items-center justify-center gap-3">
                    <span class="material-symbols-outlined text-base">picture_as_pdf</span>
                    Download PDF
                </a>
                
                <a href="{{ route('home') }}" class="group w-full bg-transparent text-secondary/60 py-4 uppercase tracking-[0.2em] text-[10px] font-black hover:text-secondary transition-all text-center block mt-4 border-b border-transparent hover:border-secondary/30">
                    Kembali ke Beranda
                </a>
            </div>

        </div>
    </div>
</div>

@endsection
