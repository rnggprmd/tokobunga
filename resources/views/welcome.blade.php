@extends('layouts.front')

@section('title', 'Mbah Bibit - Botanical Heritage')

@section('content')
<div class="max-w-screen-2xl mx-auto px-6 py-12 space-y-24">
    <!-- Hero: The Catalog Entry -->
    <header class="relative grid grid-cols-1 md:grid-cols-12 gap-12 items-center">
        <div class="md:col-span-7 space-y-6">
            <h1 class="font-headline text-7xl md:text-8xl text-secondary leading-tight">
                Dari Tradisi <br/>
                <span class="serif-italic text-primary">Kami Merangkai</span> <br/>
                Makna.
            </h1>
            <p class="text-lg text-on-surface-variant max-w-lg leading-relaxed">
                Toko Bunga Mbah Bibit menghadirkan bunga dan perlengkapan untuk pernikahan dan perpisahan, sebagai bentuk penghormatan dalam setiap perjalanan hidup.
            </p>
            <div class="pt-4 flex gap-4">
                <a href="{{ route('products.index') }}" class="bg-primary text-white px-8 py-4 rounded-full font-label font-bold text-sm tracking-widest uppercase hover:opacity-90 transition-all flex items-center gap-2 shadow-lg shadow-primary/20">
                    Jelajahi Katalog <span class="material-symbols-outlined text-sm">arrow_forward</span>
                </a>
            </div>
        </div>
        <div class="md:col-span-5 relative">
            <div class="aspect-[4/5] rounded-3xl overflow-hidden shadow-2xl rotate-2 hover:rotate-0 transition-transform duration-700 bg-[#e4e4ce]">
                <img class="w-full h-full object-cover" src="{{ asset('images/sambung tuwuh.jpeg') }}" alt="Dekorasi Tuwuhan Adat Jawa"/>
            </div>
            <div class="absolute -bottom-6 md:-bottom-8 -left-2 md:-left-8 bg-[#e4e4ce] p-6 rounded-2xl shadow-xl max-w-[200px] md:max-w-[220px] -rotate-3 z-20">
                <p class="serif-italic text-secondary text-xl">Pernikahan Adat: Tuwuhan</p>
                <p class="text-xs text-secondary mt-2">Simbol kesejahteraan dan harapan. Menjaga tradisi dalam setiap prosesi.</p>
            </div>
        </div>
    </header>

    <!-- New Arrivals -->
    <section class="space-y-12">
        <div class="flex justify-between items-end border-b border-outline-variant pb-6">
            <div class="space-y-2">
                <h2 class="font-headline text-4xl text-on-surface">Koleksi Terbaru</h2>
                <p class="text-secondary font-label">Bunga, Alat Pernikahan &amp; Alat Kematian</p>
            </div>
            <a class="text-primary font-label font-bold flex items-center gap-1 hover:underline" href="{{ route('products.index') }}">
                Lihat Semua <span class="material-symbols-outlined">north_east</span>
            </a>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-12">
            @forelse($latestProducts as $index => $product)
            <div class="group space-y-6 @if($index % 3 == 1) mt-8 lg:mt-16 @endif">
                <a href="{{ route('products.show', $product) }}" class="block aspect-[3/4] rounded-2xl overflow-hidden bg-[#e4e4ce] relative">
                    <img class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110" 
                         src="{{ $product->foto ? asset('storage/'.$product->foto) : 'https://ui-avatars.com/api/?name='.urlencode($product->nama_produk).'&background=FAFAE3&color=D9B2A9&size=512' }}" 
                         alt="{{ $product->nama_produk }}">
                    <div class="absolute top-4 right-4 bg-background/90 backdrop-blur px-3 py-1 rounded-full text-[10px] font-bold tracking-widest uppercase text-primary">
                        {{ $product->category->nama_kategori ?? 'UMUM' }}
                    </div>
                </a>
                <div class="space-y-2">
                    <div class="flex justify-between items-baseline">
                        <h3 class="font-headline text-2xl group-hover:text-primary transition-colors">
                            <a href="{{ route('products.show', $product) }}">{{ $product->nama_produk }}</a>
                        </h3>
                        <span class="font-headline text-xl text-primary font-bold">Rp {{ number_format($product->harga, 0, ',', '.') }}</span>
                    </div>
                    <p class="text-sm text-on-surface-variant leading-relaxed line-clamp-2">{{ $product->deskripsi }}</p>
                    <div class="flex gap-2 pt-2">
                        @if($product->stok <= 0)
                        <span class="bg-red-100 px-3 py-1 rounded text-[10px] text-red-500 font-bold uppercase">Out of Stock</span>
                        @endif
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-full py-20 text-center space-y-4">
                <span class="material-symbols-outlined text-6xl text-outline" data-icon="brand_awareness">brand_awareness</span>
                <p class="text-secondary italic">Koleksi kami sedang dalam proses kurasi. Kembali lagi segera!</p>
            </div>
            @endforelse
        </div>
    </section>

    <!-- Botanical Tools -->
    <section class="bg-[#f5f5de] rounded-[3rem] p-8 md:p-16 lg:p-24 relative overflow-hidden shadow-inner uppercase tracking-wider">
        <div class="absolute top-0 right-0 opacity-10 pointer-events-none">
            <span class="material-symbols-outlined text-[30rem]">local_florist</span>
        </div>
        <div class="relative grid grid-cols-1 md:grid-cols-2 gap-16 items-center">
            <div class="space-y-8">
                <div class="space-y-4">
                    <h2 class="font-headline text-5xl text-secondary">Koleksi Bunga Pilihan</h2>
                    <p class="text-secondary font-label leading-relaxed">Keindahan mahakarya alam untuk setiap momen Anda. Dirawat sepenuh hati dan dipetik di saat yang paling sempurna untuk mempertahankan warna dan keharumannya.</p>
                </div>
                <ul class="space-y-6">
                    <li class="flex gap-4 items-start">
                        <span class="material-symbols-outlined text-primary font-bold">spa</span>
                        <div>
                            <h4 class="font-bold text-on-surface">Kesegaran Terjamin</h4>
                            <p class="text-sm text-on-surface-variant">Bunga dirawat secara khusus untuk memastikan keharuman dan rupa yang prima sampai ke tangan Anda.</p>
                        </div>
                    </li>
                    <li class="flex gap-4 items-start">
                        <span class="material-symbols-outlined text-primary">psychiatry</span>
                        <div>
                            <h4 class="font-bold text-on-surface">Beragam Varian Spesies</h4>
                            <p class="text-sm text-on-surface-variant">Dari mawar klasik hingga anggrek lokal eksotis, tersedia untuk kebutuhan perayaan maupun prosesi kultural.</p>
                        </div>
                    </li>
                </ul>
                <a href="{{ route('products.index', ['category' => $categories->first()->id ?? 1]) }}" class="inline-block border border-primary text-primary px-8 py-3 rounded-full font-label font-bold text-sm tracking-widest uppercase hover:bg-primary hover:text-white transition-all">
                    Eksplor Bunga
                </a>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div class="aspect-square rounded-2xl overflow-hidden shadow-lg transform translate-y-8">
                    <img class="w-full h-full object-cover" src="{{ asset('images/bunga1.jpeg') }}" alt="Koleksi Bunga 1"/>
                </div>
                <div class="aspect-square rounded-2xl overflow-hidden shadow-lg">
                    <img class="w-full h-full object-cover" src="{{ asset('images/bunga2.jpeg') }}" alt="Koleksi Bunga 2"/>
                </div>
            </div>
        </div>
    </section>

    <!-- Bento Category Grid -->
    <section class="space-y-12">
        <h2 class="font-headline text-4xl text-center text-on-surface">Jelajahi Berdasarkan Kategori</h2>
        <div class="grid grid-cols-1 md:grid-cols-4 grid-rows-2 gap-6 h-auto md:h-[600px]">
            @foreach($categories->take(3) as $index => $category)
                @php
                    $spans = [
                        0 => 'md:col-span-2 md:row-span-2', // Large (Left)
                        1 => 'md:col-span-2 md:row-span-1', // Top Right
                        2 => 'md:col-span-2 md:row-span-1', // Bottom Right
                    ];
                    $span = $spans[$index] ?? 'md:col-span-1';
                    $placeholders = [
                        0 => asset('images/bunga.jpeg'),
                        1 => asset('images/penjor.jpeg'),
                        2 => asset('images/kain kafan.jpeg'),
                    ];
                    $defaultImg = $placeholders[$index] ?? asset('images/bunga.jpeg');
                @endphp
                <div class="{{ $span }} group relative rounded-3xl overflow-hidden bg-[#efefd9] min-h-[250px]">
                    <img class="w-full h-full object-cover transition-transform duration-1000 group-hover:scale-105" 
                         src="{{ $category->foto ? asset('storage/'.$category->foto) : $defaultImg }}" 
                         alt="{{ $category->nama_kategori }}">
                    <div class="absolute inset-0 bg-gradient-to-t from-primary/90 via-primary/20 to-transparent flex flex-col justify-end p-8 text-white md:opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                        <h3 class="font-headline text-3xl">{{ $category->nama_kategori }}</h3>
                        <p class="font-label text-sm opacity-80 mt-2 line-clamp-2">{{ $category->deskripsi }}</p>
                        <a href="{{ route('products.index', ['category' => $category->id]) }}" class="mt-4 w-fit bg-white text-primary px-6 py-2 rounded-full font-bold text-xs uppercase tracking-widest">
                            Jelajahi
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </section>
</div>
@endsection