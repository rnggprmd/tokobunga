@extends('layouts.front')

@section('title', 'Mbah Bibit - Botanical Heritage')

@section('content')
<div class="max-w-screen-2xl mx-auto px-6 py-12 space-y-24">
    <!-- Hero: The Catalog Entry -->
    <header class="relative grid grid-cols-1 md:grid-cols-12 gap-12 items-center">
        <div class="md:col-span-7 space-y-6">
            <span class="font-label text-sm uppercase tracking-[0.3em] text-secondary">Vol. 24 Botanical Archive</span>
            <h1 class="font-headline text-7xl md:text-8xl text-secondary leading-tight">
                Curating <br/>
                <span class="serif-italic text-primary">Heritage</span> <br/>
                through Nature.
            </h1>
            <p class="text-lg text-on-surface-variant max-w-lg leading-relaxed">
                A timeless sanctuary of flora and ritual essentials. From the celebratory blooms of union to the silent dignity of farewell, we preserve the soul of Javanese botanical traditions.
            </p>
            <div class="pt-4 flex gap-4">
                <a href="{{ route('products.index') }}" class="bg-primary text-white px-8 py-4 rounded-full font-label font-bold text-sm tracking-widest uppercase hover:opacity-90 transition-all flex items-center gap-2 shadow-lg shadow-primary/20">
                    Jelajahi Katalog <span class="material-symbols-outlined text-sm">arrow_forward</span>
                </a>
            </div>
        </div>
        <div class="md:col-span-5 relative">
            <div class="aspect-[4/5] rounded-3xl overflow-hidden shadow-2xl rotate-2 hover:rotate-0 transition-transform duration-700 bg-[#e4e4ce]">
                <img class="w-full h-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBdJ1WTVQG8JjZilHrp3H_Ye1W0tHQ01I0QNLXojfAWeqb1VWVsdjJRRxvrmdJroaxmTi11Qb9gw931KJDpPYlrmXqwbLhbRUgbcDM1KENNF7Eoz4_wVerFllvUaQl3WTUBkTZG_-6LpMAfKIsM7vBOjcTPEf0V8jVAHVIMKtqDGP_m8DwR43t1GzCWnA9eT89aDAk_ZtTsNec4s2rySqguUUVUQEzan2U4yMLPrUzrWhEgcw6cfU1_IdDCLFKOu_l6YmIk38Y1YzA"/>
            </div>
            <div class="absolute -bottom-8 -left-8 bg-[#e4e4ce] p-6 rounded-2xl shadow-xl max-w-[200px] -rotate-3">
                <p class="serif-italic text-secondary text-xl">Specimen 01: Bunga Sedap Malam</p>
                <p class="text-xs text-secondary mt-2">Polianthes tuberosa. The fragrance of evening ceremonies.</p>
            </div>
        </div>
    </header>

    <!-- New Arrivals -->
    <section class="space-y-12">
        <div class="flex justify-between items-end border-b border-outline-variant pb-6">
            <div class="space-y-2">
                <h2 class="font-headline text-4xl text-on-surface">Koleksi Terbaru</h2>
                <p class="text-secondary font-label">Tangkapan Musim Semi &amp; Perangkat Upacara</p>
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
    <section class="bg-[#f5f5de] rounded-[3rem] p-12 lg:p-24 relative overflow-hidden">
        <div class="absolute top-0 right-0 opacity-10 pointer-events-none">
            <span class="material-symbols-outlined text-[30rem]">eco</span>
        </div>
        <div class="relative grid grid-cols-1 md:grid-cols-2 gap-16 items-center">
            <div class="space-y-8">
                <div class="space-y-4">
                    <h2 class="font-headline text-5xl text-secondary">Peralatan Perawatan Botanical</h2>
                    <p class="text-secondary font-label leading-relaxed">Tools for the serious collector. Each piece is crafted for precision, durability, and a tactile connection to the Earth.</p>
                </div>
                <ul class="space-y-6">
                    <li class="flex gap-4 items-start">
                        <span class="material-symbols-outlined text-primary font-bold">architecture</span>
                        <div>
                            <h4 class="font-bold text-on-surface">Precision Pruning Scissors</h4>
                            <p class="text-sm text-on-surface-variant">Forged steel for clean, botanical-grade cuts that preserve stem health.</p>
                        </div>
                    </li>
                    <li class="flex gap-4 items-start">
                        <span class="material-symbols-outlined text-primary">humidity_percentage</span>
                        <div>
                            <h4 class="font-bold text-on-surface">Copper Mist Atomizer</h4>
                            <p class="text-sm text-on-surface-variant">Ultrafine hydration for delicate orchid species and ferns.</p>
                        </div>
                    </li>
                </ul>
                <a href="#" class="inline-block border border-primary text-primary px-8 py-3 rounded-full font-label font-bold text-sm tracking-widest uppercase hover:bg-primary hover:text-white transition-all">
                    Eksplor Peralatan
                </a>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div class="aspect-square rounded-2xl overflow-hidden shadow-lg transform translate-y-8">
                    <img class="w-full h-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuAaDNt4GnlqCySYK2HT8h8A-Jhx3ACuOHCyuNaAp7NiPP7tYEvCK5JpAkNKWvbPL3LWAVXCE8yOUGP2h8pipZjZrwxKOsqee3TXP3MVMlIfCbPObU90eiyT76v9NtOqRcgZsVMhUhoyuZxVHthkBrdU4g71Xu5NDj9xooM0h3PilXToTl7HIuCPQmtvjqNyusXAn4m6CwhesC4_7m0wHl9803OTeFpokJmATFvKSkLn1qg7HH4bgVKalLJuuSdqxziRCsvg8M9_3MA"/>
                </div>
                <div class="aspect-square rounded-2xl overflow-hidden shadow-lg">
                    <img class="w-full h-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuATGQcgDLoMK9appAT0Ej9fz6nXnlWpV0BmN1E74rVQipdxhkHJz6G_Y-Q2Kc0E-jJjcfQkomwLrd0HceUWqSwWJ5AZ2KboTnMM9OIvay-IEdS1xAyLnNO40pqMZDf15Q7iU1vtql3YmurMyBClvfyeFVdc3tSl68hQ0tdrWeMctvIJ_64KFSQx8YdiQPoRX2NPc-ZQAjBaMogy0DpJtUff0EGzCdPy18RpU95oSguMS4YBnF4_022WXbn_uqP8gCn6oXipp9caAxc"/>
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
                        'Bunga Segar' => 'https://images.unsplash.com/photo-1526047932273-341f2a7631f9?auto=format&fit=crop&q=80&w=800',
                        'Pernikahan' => 'https://images.unsplash.com/photo-1519741497674-611481863552?auto=format&fit=crop&q=80&w=800',
                        'Kematian' => 'https://images.unsplash.com/photo-1516663243144-8463a51052fe?auto=format&fit=crop&q=80&w=800',
                        'Alat' => 'https://images.unsplash.com/photo-1589923188900-85dae523342b?auto=format&fit=crop&q=80&w=800',
                    ];
                    $defaultImg = $placeholders[$category->nama_kategori] ?? 'https://images.unsplash.com/photo-1490750967868-88aa4486c946?auto=format&fit=crop&q=80&w=800';
                @endphp
                <div class="{{ $span }} group relative rounded-3xl overflow-hidden bg-[#efefd9] min-h-[250px]">
                    <img class="w-full h-full object-cover transition-transform duration-1000 group-hover:scale-105" 
                         src="{{ $category->foto ? asset('storage/'.$category->foto) : $defaultImg }}" 
                         alt="{{ $category->nama_kategori }}">
                    <div class="absolute inset-0 bg-gradient-to-t from-primary/80 to-transparent flex flex-col justify-end p-8 text-white opacity-0 group-hover:opacity-100 transition-opacity duration-500">
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