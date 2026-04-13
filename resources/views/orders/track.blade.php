@extends('layouts.front')

@section('title', 'Lacak Pesanan - Mbah Bibit')

@section('content')
<div class="max-w-4xl mx-auto px-6 py-24">
    <div class="space-y-12 text-center">
        <header class="space-y-4">
            <span class="material-symbols-outlined text-6xl text-primary font-light">local_shipping</span>
            <h1 class="font-headline text-5xl text-secondary leading-tight">Pantau Perjalanan <br/><span class="serif-italic">Botanikal</span> Anda</h1>
            <p class="text-on-surface-variant max-w-lg mx-auto leading-relaxed">Masukkan Nomor Pesanan dan Email Anda untuk melihat status terkini dari pesanan Anda.</p>
        </header>

        <div class="bg-surface p-8 md:p-12 rounded-[3rem] shadow-xl border border-primary/10 max-w-xl mx-auto">
            <form action="#" method="GET" class="space-y-6 text-left">
                <div class="space-y-2">
                    <label class="text-[10px] font-black uppercase tracking-widest text-secondary/60">Nomor Pesanan</label>
                    <input type="text" name="order_id" required class="w-full bg-background border-primary/20 rounded-2xl p-4 text-sm focus:ring-primary focus:border-primary" placeholder="Contoh: #ORD-12345">
                </div>
                
                <div class="space-y-2">
                    <label class="text-[10px] font-black uppercase tracking-widest text-secondary/60">Email Pembelian</label>
                    <input type="email" name="email" required class="w-full bg-background border-primary/20 rounded-2xl p-4 text-sm focus:ring-primary focus:border-primary" placeholder="nama@email.com">
                </div>

                <div class="pt-4">
                    <button type="submit" class="w-full bg-primary text-white py-4 rounded-full font-bold text-sm uppercase tracking-widest hover:shadow-lg hover:shadow-primary/20 transition-all flex items-center justify-center gap-3">
                        <span class="material-symbols-outlined">track_changes</span>
                        Lacak Sekarang
                    </button>
                </div>
            </form>
        </div>

        <div class="pt-12 grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="space-y-2">
                <div class="w-10 h-10 bg-primary/10 rounded-full flex items-center justify-center mx-auto text-primary">
                    <span class="material-symbols-outlined">payments</span>
                </div>
                <h4 class="font-bold text-secondary text-sm">Pembayaran</h4>
                <p class="text-[10px] text-secondary/60">Pesanan dikonfirmasi setelah pembayaran tuntas.</p>
            </div>
            <div class="space-y-2">
                <div class="w-10 h-10 bg-primary/10 rounded-full flex items-center justify-center mx-auto text-primary">
                    <span class="material-symbols-outlined">inventory_2</span>
                </div>
                <h4 class="font-bold text-secondary text-sm">Persiapan</h4>
                <p class="text-[10px] text-secondary/60">Bunga dirangkai segar oleh tim Mbah Bibit.</p>
            </div>
            <div class="space-y-2">
                <div class="w-10 h-10 bg-primary/10 rounded-full flex items-center justify-center mx-auto text-primary">
                    <span class="material-symbols-outlined">shipped</span>
                </div>
                <h4 class="font-bold text-secondary text-sm">Pengiriman</h4>
                <p class="text-[10px] text-secondary/60">Menuju lokasi Anda dengan kurir khusus.</p>
            </div>
        </div>
    </div>
</div>
@endsection
