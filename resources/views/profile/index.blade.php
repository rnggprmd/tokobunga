@extends('layouts.front')

@section('title', 'Profil Akun — Mbah Bibit')

@section('content')

{{-- === TOP RULE === --}}
<div class="w-full border-t border-secondary/20"></div>

<div class="max-w-screen-xl mx-auto min-h-screen">
    
    {{-- === MASTHEAD === --}}
    <div class="grid grid-cols-12 border-b border-secondary/20">
        {{-- Label col --}}
        <div class="col-span-12 md:col-span-3 border-b md:border-b-0 md:border-r border-secondary/20 px-8 py-6 flex items-center">
            <div>
                <p class="text-[9px] font-black uppercase tracking-[0.3em] text-secondary/40">Akun Pelanggan</p>
                <p class="text-[9px] font-black uppercase tracking-[0.3em] text-secondary/40 mt-0.5">Profil Saya</p>
            </div>
        </div>
        {{-- Headline col --}}
        <div class="col-span-12 md:col-span-9 px-8 md:px-16 py-12 flex flex-col md:flex-row md:items-end justify-between gap-8">
                {{ explode(' ', $user->name)[0] }}<br><span class="serif-italic text-primary">Profil</span>
            </h1>
            
            <form action="{{ route('logout') }}" method="POST" class="mb-2">
                @csrf
                <button type="submit" class="text-[10px] font-black uppercase tracking-[0.3em] text-secondary/40 hover:text-accent-rose transition-colors border-b border-transparent hover:border-accent-rose pb-1">
                    Keluar Akun —
                </button>
            </form>
        </div>
    </div>

    {{-- === BODY AREA === --}}
    <div class="grid grid-cols-12 min-h-[60vh]">
        
        {{-- LEFT: User Identities --}}
        <div class="col-span-12 lg:col-span-4 border-b lg:border-b-0 md:border-r border-secondary/20">
            <div class="p-8 md:p-12 space-y-12">
                {{-- Profile Pic placeholder / Initial --}}
                <div class="w-32 h-32 border border-secondary/20 flex items-center justify-center relative group">
                    <span class="font-headline text-6xl text-secondary group-hover:text-primary transition-colors">{{ substr($user->name, 0, 1) }}</span>
                    <div class="absolute inset-2 border border-secondary/5"></div>
                </div>

                <div class="space-y-10">
                    <div>
                        <p class="text-[9px] font-black uppercase tracking-[0.3em] text-secondary/30 mb-4">Informasi Kontak</p>
                        <div class="space-y-4">
                            <div class="flex flex-col">
                                <span class="text-[10px] text-secondary/40 uppercase tracking-widest mb-1">Email Resmi</span>
                                <span class="text-sm font-bold text-secondary">{{ $user->email }}</span>
                            </div>
                            <div class="flex flex-col">
                                <span class="text-[10px] text-secondary/40 uppercase tracking-widest mb-1">WhatsApp</span>
                                <span class="text-sm font-bold text-secondary">{{ $user->phone ?? $user->no_hp ?? '—' }}</span>
                            </div>
                        </div>
                    </div>

                    <div>
                        <p class="text-[9px] font-black uppercase tracking-[0.3em] text-secondary/30 mb-4">Alamat Pengiriman Default</p>
                        <p class="text-sm text-secondary/70 leading-relaxed italic">
                            {{ $user->address ?? $user->alamat ?? 'Belum ada alamat pengiriman terdaftar.' }}
                        </p>
                    </div>
                    
                    <div class="pt-8 border-t border-secondary/10">
                         <p class="text-[9px] text-secondary/30 italic uppercase tracking-widest leading-relaxed">
                             Terdaftar di Toko Bunga Mbah Bibit sejak<br>
                            {{ $user->created_at->translatedFormat('F Y') }}
                         </p>
                    </div>
                </div>
            </div>
            
            {{-- Edit Profile Form --}}
            <div class="px-8 md:p-12 border border-secondary/20 bg-secondary/[0.01]">
                <p class="text-[9px] font-black uppercase tracking-[0.3em] text-secondary/30 mb-8">Pengaturan Akun</p>
                
                @if(session('success'))
                <div class="mb-6 py-3 border-b border-emerald-200 text-emerald-700 text-[10px] font-black uppercase tracking-widest">
                    {{ session('success') }}
                </div>
                @endif

                <form action="{{ route('profile.update') }}" method="POST" class="space-y-8">
                    @csrf @method('PATCH')
                    
                    <div class="space-y-2 group">
                        <label class="text-[9px] font-black uppercase tracking-widest text-secondary/40 group-focus-within:text-primary transition-colors">Nomor WhatsApp</label>
                        <input type="text" name="no_hp" value="{{ $user->no_hp }}" 
                               class="w-full bg-transparent border-b border-secondary/20 border-t-0 border-l-0 border-r-0 p-0 pb-2 text-sm text-secondary focus:ring-0 focus:border-primary transition-all font-bold"
                               placeholder="0812 ···">
                    </div>

                    <div class="space-y-2 group">
                        <label class="text-[9px] font-black uppercase tracking-widest text-secondary/40 group-focus-within:text-primary transition-colors">Alamat Pengiriman</label>
                        <textarea name="alamat" rows="4" 
                                  class="w-full bg-transparent border-b border-secondary/20 border-t-0 border-l-0 border-r-0 p-0 pb-2 text-sm text-secondary focus:ring-0 focus:border-primary transition-all resize-none leading-relaxed"
                                  placeholder="Nama jalan, nomor rumah, kelurahan... ">{{ $user->alamat }}</textarea>
                    </div>

                    <div class="pt-4">
                        <button type="submit" class="w-full bg-secondary text-[#FAFAE3] py-4 uppercase tracking-[0.2em] text-[10px] font-black hover:bg-primary transition-colors">
                            Simpan Pembaruan
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- RIGHT: Order Archive --}}
        <div class="col-span-12 lg:col-span-8 flex flex-col">
            <div class="px-8 md:px-12 py-8 bg-secondary/[0.02] border-b border-secondary/20">
                <p class="text-[10px] font-black uppercase tracking-[0.3em] text-secondary/40">Riwayat Pesanan</p>
            </div>

            <div class="flex-1">
                @if($user->orders->count() > 0)
                    @foreach($user->orders as $order)
                    <div class="grid grid-cols-12 border-b border-secondary/15 last:border-b-0 hover:bg-secondary/[0.01] transition-colors group">
                        {{-- Order Identity --}}
                        <div class="col-span-12 md:col-span-4 p-8 md:border-r border-secondary/15">
                            <p class="text-[9px] font-black uppercase tracking-widest text-secondary/30 mb-2">Reference</p>
                            <h4 class="font-headline text-2xl text-secondary mb-2">#ORD-{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</h4>
                            <p class="text-[10px] text-secondary/40 uppercase tracking-widest">{{ $order->created_at->translatedFormat('d M Y · H:i') }}</p>
                        </div>

                        {{-- Order Content --}}
                        <div class="col-span-12 md:col-span-5 p-8 border-t md:border-t-0 border-secondary/15">
                            <p class="text-[9px] font-black uppercase tracking-widest text-secondary/30 mb-4">Daftar Produk</p>
                            <div class="space-y-3">
                                @foreach($order->items as $item)
                                <div class="space-y-4">
                                    <div class="flex items-center justify-between gap-4">
                                        <div class="flex items-baseline gap-4">
                                            <span class="text-[10px] font-black text-primary">{{ $item->jumlah }}×</span>
                                            <span class="text-xs text-secondary/70 uppercase tracking-wide">{{ $item->product->nama_produk ?? 'Custom Request' }}</span>
                                        </div>
                                        
                                        @if($order->status === 'completed' && $item->product_id)
                                            @php 
                                                $hasReviewed = \App\Models\ProductReview::where('user_id', Auth::id())
                                                    ->where('product_id', $item->product_id)
                                                    ->exists();
                                            @endphp
                                            
                                            @if(!$hasReviewed)
                                                <button onclick="document.getElementById('review-form-{{ $item->id }}').classList.toggle('hidden')" 
                                                        class="text-[9px] font-black uppercase tracking-widest text-primary border-b border-primary/20 hover:border-primary pb-px transition-all">
                                                    Beri Ulasan +
                                                </button>
                                            @else
                                                <span class="text-[8px] font-black uppercase tracking-widest text-emerald-600/50">Sudah Diulas</span>
                                            @endif
                                        @endif
                                    </div>

                                    {{-- Review Form --}}
                                    @if($order->status === 'completed' && $item->product_id && !$hasReviewed)
                                    <div id="review-form-{{ $item->id }}" class="hidden pt-4 pb-6 border-t border-secondary/5 animate-in fade-in slide-in-from-top-2 duration-300">
                                        <form action="{{ route('reviews.store') }}" method="POST" class="space-y-4">
                                            @csrf
                                            <input type="hidden" name="product_id" value="{{ $item->product_id }}">
                                            
                                            <div class="flex flex-col gap-3">
                                                <p class="text-[9px] font-black uppercase tracking-widest text-secondary/30">Rating Produk</p>
                                                <div class="flex gap-4">
                                                    @foreach([1,2,3,4,5] as $star)
                                                    <label class="cursor-pointer group">
                                                        <input type="radio" name="rating" value="{{ $star }}" class="peer hidden" required {{ $star == 5 ? 'checked' : '' }}>
                                                        <span class="material-symbols-outlined text-sm text-secondary/20 peer-checked:text-primary group-hover:text-primary/60 transition-colors" style="font-variation-settings: 'FILL' 1">
                                                            star
                                                        </span>
                                                    </label>
                                                    @endforeach
                                                </div>
                                            </div>

                                            <div class="space-y-2 group">
                                                <p class="text-[9px] font-black uppercase tracking-widest text-secondary/30">Kesan Anda</p>
                                                <textarea name="comment" rows="2" required 
                                                          class="w-full bg-transparent border-b border-secondary/10 border-t-0 border-l-0 border-r-0 p-0 pb-2 text-xs text-secondary focus:ring-0 focus:border-primary transition-all resize-none italic"
                                                          placeholder="Bagaimana kualitas bunga dan rangkaiannya?"></textarea>
                                            </div>

                                            <button type="submit" class="bg-secondary text-[#FAFAE3] px-6 py-2 uppercase tracking-widest text-[9px] font-black hover:bg-primary transition-colors">
                                                Kirim Ulasan
                                            </button>
                                        </form>
                                    </div>
                                    @endif
                                </div>
                                @endforeach
                            </div>
                            <div class="mt-6 pt-4 border-t border-secondary/10">
                                <p class="font-headline text-xl text-secondary font-bold">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</p>
                            </div>
                        </div>

                        {{-- Statuses --}}
                        <div class="col-span-12 md:col-span-3 p-8 border-t md:border-t-0 border-secondary/15 flex flex-col gap-3 justify-center">
                            @php
                                $payStatus = $order->pembayaran->status_pembayaran ?? 'pending';
                                $shipStatus = $order->pengiriman->status_pengiriman ?? 'pending';
                                
                                $payColor = $payStatus === 'paid' ? 'text-emerald-700 border-emerald-200 bg-emerald-50/50' : 'text-amber-700 border-amber-200 bg-amber-50/50';
                                $shipColor = $shipStatus === 'sampai' ? 'text-emerald-700 border-emerald-200 bg-emerald-50/50' : 'text-blue-700 border-blue-200 bg-blue-50/50';
                            @endphp
                            
                            <div class="flex flex-col gap-2">
                                <div class="flex items-center justify-between">
                                    <span class="text-[8px] font-black uppercase text-secondary/30 tracking-widest">Payment</span>
                                    <span class="border px-3 py-1 text-[9px] font-black uppercase tracking-widest {{ $payColor }}">{{ $payStatus }}</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-[8px] font-black uppercase text-secondary/30 tracking-widest">Shipping</span>
                                    <span class="border px-3 py-1 text-[9px] font-black uppercase tracking-widest {{ $shipColor }}">{{ $shipStatus }}</span>
                                </div>
                            </div>

                            @if(($order->status ?? 'pending') == 'pending')
                                <a href="{{ route('checkout.payment', $order->id) }}" class="block w-full text-center bg-secondary text-[#FAFAE3] py-3 text-[9px] font-black uppercase tracking-widest hover:bg-primary transition-colors mt-2">
                                    Bayar Sekarang
                                </a>
                            @endif

                            @if($order->pengiriman)
                                <div class="mt-2 py-3 px-3 border border-secondary/10 bg-secondary/[0.02] space-y-1">
                                    <div class="flex items-center justify-between">
                                        <span class="text-[8px] font-black uppercase text-secondary/30 tracking-widest">Kurir</span>
                                        <span class="text-[10px] font-bold text-secondary">{{ $order->pengiriman->assignedKurir->name ?? ($order->pengiriman->kurir ?? '-') }}</span>
                                    </div>
                                    @php
                                        $kurirPhone = $order->pengiriman->assignedKurir->no_hp ?? ($order->pengiriman->no_hp_kurir ?? null);
                                    @endphp
                                    @if($kurirPhone)
                                    <div class="flex items-center justify-between">
                                        <span class="text-[8px] font-black uppercase text-secondary/30 tracking-widest">Kontak</span>
                                        <span class="text-[10px] font-bold text-primary">{{ $kurirPhone }}</span>
                                    </div>
                                    @endif
                                </div>
                            @endif

                                {{-- Order Receipt Confirmation removed --}}
                        </div>
                    </div>
                    @endforeach
                @else
                    <div class="py-40 text-center">
                        <p class="font-headline text-3xl text-secondary/20 italic mb-8">Belum Ada Riwayat Pesanan</p>
                        <a href="{{ route('products.index') }}" class="inline-block bg-secondary text-[#FAFAE3] px-10 py-5 uppercase tracking-widest text-[11px] font-black hover:bg-primary transition-colors">
                            Mulai Belanja —
                        </a>
                    </div>
                @endif
            </div>

            <div class="border-t border-secondary/20 px-8 py-6 bg-secondary/[0.01]">
                <p class="text-[9px] text-secondary/40 uppercase tracking-[0.4em] text-center">Profil Keanggotaan Terverifikasi</p>
            </div>
        </div>
    </div>
</div>

<div class="w-full border-t border-secondary/20 mt-8"></div>

@endsection
