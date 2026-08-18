@extends('layouts.front')

@section('title', '500 Terjadi Kesalahan — Mbah Bibit')

@section('content')
<div class="w-full border-t border-secondary/20"></div>

<div class="max-w-screen-xl mx-auto min-h-[70vh] flex items-center justify-center px-8 py-20">
    <div class="text-center max-w-lg space-y-6">
        <p class="text-[10px] font-black uppercase tracking-[0.4em] text-red-500/80">Kesalahan 500</p>
        
        <h1 class="font-headline text-[clamp(3rem,8vw,5rem)] text-secondary leading-none">
            Terjadi Kendala <br><span class="serif-italic text-primary">Pada Server</span>
        </h1>
        
        <p class="text-sm text-secondary/70 leading-relaxed">
            Mohon maaf, sistem kami sedang mengalami kendala internal sementara. Tim teknis kami telah mencatat masalah ini untuk segera ditangani.
        </p>

        <div class="pt-6 flex justify-center gap-4">
            <a href="{{ route('home') }}" 
               class="bg-secondary text-[#FAFAE3] px-8 py-4 uppercase tracking-[0.2em] text-[11px] font-black hover:bg-primary transition-all rounded-full shadow-lg shadow-secondary/10">
                Kembali ke Beranda
            </a>
            <a href="https://wa.me/6281234567890" target="_blank"
               class="border border-secondary/30 text-secondary px-8 py-4 uppercase tracking-[0.2em] text-[11px] font-black hover:bg-secondary/5 transition-all rounded-full flex items-center gap-2">
                Hubungi Kami via WA
            </a>
        </div>
    </div>
</div>

<div class="w-full border-t border-secondary/20"></div>
@endsection
