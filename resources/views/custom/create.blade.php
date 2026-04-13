@extends('layouts.front')

@section('title', 'Pesanan Kustom - Mbah Bibit')

@section('content')
<div class="max-w-4xl mx-auto px-6 py-12">
    <div class="space-y-12">
        <header class="text-center space-y-4">
            <span class="font-label text-xs uppercase tracking-[0.3em] text-primary">Custom Botanical Service</span>
            <h1 class="font-headline text-5xl md:text-6xl text-secondary leading-tight">Wujudkan Visi <br/><span class="serif-italic">Botanikal</span> Anda</h1>
            <p class="text-on-surface-variant max-w-xl mx-auto">Sampaikan keinginan Anda untuk rangkaian bunga spesial—dari hiasan pernikahan yang sakral hingga ucapan duka yang penuh hormat.</p>
        </header>

        <div class="bg-surface p-8 md:p-12 rounded-[3rem] shadow-2xl border border-primary/10">
            <form action="#" method="POST" class="space-y-8">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="space-y-2">
                        <label class="text-xs font-black uppercase tracking-widest text-secondary/60">Nama Pelanggan</label>
                        <input type="text" name="customer_name" required class="w-full bg-background border-primary/20 rounded-2xl p-4 text-sm focus:ring-primary focus:border-primary" placeholder="Masukan nama lengkap">
                    </div>
                    <div class="space-y-2">
                        <label class="text-xs font-black uppercase tracking-widest text-secondary/60">Nomor WhatsApp</label>
                        <input type="text" name="whatsapp_number" required class="w-full bg-background border-primary/20 rounded-2xl p-4 text-sm focus:ring-primary focus:border-primary" placeholder="Contoh: 0812...">
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="text-xs font-black uppercase tracking-widest text-secondary/60">Tujuan Rangkaian</label>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        @foreach($categories as $category)
                        <label class="relative cursor-pointer group">
                            <input type="radio" name="request_type" value="{{ $category->nama_kategori }}" class="peer hidden">
                            <div class="p-4 text-center border border-primary/20 rounded-2xl text-xs font-bold text-secondary peer-checked:bg-primary peer-checked:text-white transition-all hover:bg-primary/5">
                                {{ $category->nama_kategori }}
                            </div>
                        </label>
                        @endforeach
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="text-xs font-black uppercase tracking-widest text-secondary/60">Detail Keinginan</label>
                    <textarea name="request_details" rows="6" required class="w-full bg-background border-primary/20 rounded-3xl p-6 text-sm focus:ring-primary focus:border-primary" placeholder="Ceritakan detail rangkaian, warna dominan, atau bunga spesifik yang diinginkan..."></textarea>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="space-y-2">
                        <label class="text-xs font-black uppercase tracking-widest text-secondary/60">Budget Perkiraan (Rp)</label>
                        <input type="number" name="budget_estimate" class="w-full bg-background border-primary/20 rounded-2xl p-4 text-sm focus:ring-primary focus:border-primary" placeholder="Contoh: 500000">
                    </div>
                    <div class="space-y-2">
                        <label class="text-xs font-black uppercase tracking-widest text-secondary/60">Estimasi Tanggal</label>
                        <input type="date" name="estimated_date" class="w-full bg-background border-primary/20 rounded-2xl p-4 text-sm focus:ring-primary focus:border-primary">
                    </div>
                </div>

                <div class="pt-4">
                    <button type="submit" class="w-full bg-secondary text-white py-5 rounded-full font-bold text-sm uppercase tracking-widest hover:bg-primary transition-all shadow-xl shadow-secondary/20 flex items-center justify-center gap-3">
                        <span class="material-symbols-outlined">send</span>
                        Kirim Permintaan Konsultasi
                    </button>
                    <p class="text-center text-[10px] text-secondary/60 mt-4 italic">*Tim Mbah Bibit akan menghubungi Anda via WhatsApp setelah meninjau permintaan ini.</p>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
