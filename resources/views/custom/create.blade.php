@extends('layouts.front')

@section('title', 'Layanan Kustom — Mbah Bibit')

@section('content')

{{-- === TOP RULE === --}}
<div class="w-full border-t border-secondary/20"></div>

<div class="max-w-screen-xl mx-auto">

    {{-- === MASTHEAD === --}}
    <div class="grid grid-cols-12 border-b border-secondary/20">
        {{-- Label col --}}
        <div class="col-span-12 md:col-span-3 border-b md:border-b-0 md:border-r border-secondary/20 px-8 py-6 flex items-center">
            <div>
                <p class="text-[9px] font-black uppercase tracking-[0.3em] text-secondary/40">Mbah Bibit Studio</p>
                <p class="text-[9px] font-black uppercase tracking-[0.3em] text-secondary/40 mt-0.5">Layanan Kustom</p>
            </div>
        </div>
        {{-- Headline col --}}
        <div class="col-span-12 md:col-span-9 px-8 md:px-16 py-12">
            <h1 class="font-headline text-[clamp(3rem,10vw,7rem)] text-secondary leading-none tracking-tight">
                Permintaan<br><span class="serif-italic text-primary">Khusus</span>
            </h1>
        </div>
    </div>

    {{-- === BODY AREA === --}}
    <div class="grid grid-cols-12">

        {{-- LEFT: Info panel --}}
        <div class="col-span-12 md:col-span-4 border-b md:border-b-0 md:border-r border-secondary/20 flex flex-col">
            <div class="px-8 py-12 space-y-10 flex-1">
                <p class="text-secondary/70 leading-[1.9] text-[15px]">
                    Setiap komposisi yang kami ciptakan adalah percakapan antara alam dan kehendak Anda. Sampaikan cerita momen Anda—kami akan merancang bahasa bunganya.
                </p>

                <div class="space-y-0">
                    <div class="py-6 border-t border-secondary/10 flex items-start gap-5">
                        <span class="text-[11px] font-black uppercase tracking-[0.2em] text-secondary/30 w-8 shrink-0 mt-0.5">01</span>
                        <div>
                            <p class="text-sm font-bold text-secondary mb-1">Kirim Permintaan</p>
                            <p class="text-[12px] text-secondary/50 leading-relaxed">Isi formulir singkat ini dan jelaskan momen yang Anda rayakan.</p>
                        </div>
                    </div>
                    <div class="py-6 border-t border-secondary/10 flex items-start gap-5">
                        <span class="text-[11px] font-black uppercase tracking-[0.2em] text-secondary/30 w-8 shrink-0 mt-0.5">02</span>
                        <div>
                            <p class="text-sm font-bold text-secondary mb-1">Konsultasi Personal</p>
                            <p class="text-[12px] text-secondary/50 leading-relaxed">Tim kami menghubungi Anda via WhatsApp dalam 1×24 jam.</p>
                        </div>
                    </div>
                    <div class="py-6 border-t border-secondary/10 flex items-start gap-5">
                        <span class="text-[11px] font-black uppercase tracking-[0.2em] text-secondary/30 w-8 shrink-0 mt-0.5">03</span>
                        <div>
                            <p class="text-sm font-bold text-secondary mb-1">Kurasi & Eksekusi</p>
                            <p class="text-[12px] text-secondary/50 leading-relaxed">Kami mewujudkan visi Anda dengan tangan dan dedikasi warisan.</p>
                        </div>
                    </div>
                    <div class="py-6 border-t border-secondary/10"></div>
                </div>
            </div>

            {{-- Bottom info strip --}}
            <div class="border-t border-secondary/20 px-8 py-5">
                <p class="text-[10px] text-secondary/40 uppercase tracking-widest">Solo & Sekitarnya · Est. 1978</p>
            </div>
        </div>

        {{-- RIGHT: Form --}}
        <div class="col-span-12 md:col-span-8 px-8 md:px-16 py-12">

            @if(session('success'))
            <div class="mb-10 flex items-center gap-4 border-l-4 border-secondary pl-6 py-4">
                <span class="material-symbols-outlined text-secondary">check_circle</span>
                <p class="text-sm text-secondary font-medium">{{ session('success') }}</p>
            </div>
            @endif

            <form action="{{ route('custom.store') }}" method="POST" class="space-y-0" id="custom-form">
                @csrf

                {{-- Field 1: Nama --}}
                <div class="py-8 border-b border-secondary/15 group focus-within:border-secondary/50 transition-colors">
                    <label class="block text-[9px] font-black uppercase tracking-[0.3em] text-secondary/30 mb-3 group-focus-within:text-secondary/60 transition-colors">Nama Pelanggan</label>
                    <input type="text" name="customer_name" required autocomplete="off"
                           class="w-full bg-transparent border-none p-0 text-2xl md:text-3xl font-headline text-secondary placeholder:text-secondary/15 focus:ring-0 focus:outline-none"
                           placeholder="Nama Lengkap Anda">
                </div>

                {{-- Field 2: WhatsApp --}}
                <div class="py-8 border-b border-secondary/15 group focus-within:border-secondary/50 transition-colors">
                    <label class="block text-[9px] font-black uppercase tracking-[0.3em] text-secondary/30 mb-3 group-focus-within:text-secondary/60 transition-colors">Nomor WhatsApp</label>
                    <input type="text" name="whatsapp_number" required autocomplete="off"
                           class="w-full bg-transparent border-none p-0 text-2xl md:text-3xl font-headline text-secondary placeholder:text-secondary/15 focus:ring-0 focus:outline-none"
                           placeholder="0812 ···">
                </div>

                {{-- Field 3: Kategori --}}
                <div class="py-8 border-b border-secondary/15">
                    <label class="block text-[9px] font-black uppercase tracking-[0.3em] text-secondary/30 mb-5">Untuk Keperluan</label>
                    <div class="flex flex-wrap gap-2">
                        @php
                            $eventTypes = ['Pernikahan', 'Ziarah', 'Ulang Tahun', 'Duka Cita', 'Hantaran', 'Acara Korporat'];
                        @endphp
                        @foreach($categories as $category)
                        <label class="cursor-pointer">
                            <input type="radio" name="request_type" value="{{ $category->nama_kategori }}" class="peer hidden" required>
                            <span class="inline-block border border-secondary/20 px-5 py-2 text-[11px] font-black uppercase tracking-widest text-secondary/50 cursor-pointer peer-checked:border-secondary peer-checked:text-secondary peer-checked:bg-secondary/5 hover:border-secondary/40 hover:text-secondary/70 transition-all duration-200 select-none">
                                {{ $category->nama_kategori }}
                            </span>
                        </label>
                        @endforeach
                    </div>
                </div>

                {{-- Field 4: Detail --}}
                <div class="py-8 border-b border-secondary/15 group focus-within:border-secondary/50 transition-colors">
                    <label class="block text-[9px] font-black uppercase tracking-[0.3em] text-secondary/30 mb-3 group-focus-within:text-secondary/60 transition-colors">Ceritakan Keinginan Anda</label>
                    <textarea name="request_details" rows="6" required
                              class="w-full bg-transparent border-none p-0 text-base text-secondary/80 placeholder:text-secondary/15 focus:ring-0 focus:outline-none resize-none leading-relaxed"
                              placeholder="Warna favorit, jenis bunga, suasana yang ingin diciptakan, atau detail momen yang Anda rayakan…"></textarea>
                </div>

                {{-- Submit Row --}}
                <div class="pt-10 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-6">
                    <p class="text-[10px] uppercase tracking-widest text-secondary/30 leading-relaxed">
                        Tim kami akan membalas via WhatsApp<br>dalam 1×24 jam kerja.
                    </p>
                    <button type="submit"
                            class="group inline-flex items-center gap-4 bg-secondary text-[#FAFAE3] px-10 py-5 uppercase tracking-widest text-[11px] font-black hover:bg-primary transition-colors duration-300 shrink-0">
                        Kirim Permintaan
                        <span class="material-symbols-outlined text-lg transition-transform duration-300 group-hover:translate-x-1">arrow_forward</span>
                    </button>
                </div>
            </form>
        </div>

    </div>
</div>

{{-- === BOTTOM RULE === --}}
<div class="w-full border-t border-secondary/20 mt-8"></div>

@endsection
