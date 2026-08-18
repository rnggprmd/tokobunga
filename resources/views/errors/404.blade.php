@extends('layouts.front')

@section('title', '404 Halaman Tidak Ditemukan — Mbah Bibit')

@section('content')
<div class="w-full border-t border-secondary/20"></div>

<div class="max-w-screen-xl mx-auto min-h-[70vh] flex items-center justify-center px-8 py-20">
    <div class="text-center max-w-lg space-y-6">
        <p class="text-[10px] font-black uppercase tracking-[0.4em] text-secondary/40">Kesalahan 404</p>
        
        <h1 class="font-headline text-[clamp(3rem,8vw,5rem)] text-secondary leading-none">
            Halaman Tidak <br><span class="serif-italic text-primary">Ditemukan</span>
        </h1>
        
        <p class="text-sm text-secondary/70 leading-relaxed">
            Halaman yang Anda cari mungkin telah dipindahkan, dihapus, atau alamat URL yang dimasukkan salah.
        </p>

        <div class="pt-6 flex justify-center gap-4">
            <a href="{{ route('home') }}" 
               class="bg-secondary text-[#FAFAE3] px-8 py-4 uppercase tracking-[0.2em] text-[11px] font-black hover:bg-primary transition-all rounded-full shadow-lg shadow-secondary/10">
                Kembali ke Beranda
            </a>
            <a href="{{ route('products.index') }}" 
               class="border border-secondary/30 text-secondary px-8 py-4 uppercase tracking-[0.2em] text-[11px] font-black hover:bg-secondary/5 transition-all rounded-full">
                Katalog Produk
            </a>
        </div>
    </div>
</div>

<div class="w-full border-t border-secondary/20"></div>
@endsection
