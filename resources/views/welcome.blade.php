<!DOCTYPE html>

<html class="light" lang="id"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com/css2?family=Newsreader:ital,opsz,wght@0,6..72,200..800;1,6..72,200..800&amp;family=Manrope:wght@200..800&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<script id="tailwind-config">
      tailwind.config = {
        darkMode: "class",
        theme: {
          extend: {
            "colors": {
                    "background": "#FAFAE3",
                    "tertiary": "#685a67",
                    "primary-fixed": "#ffdad2",
                    "primary": "#D9B2A9",
                    "surface-dim": "#dbdbc5",
                    "on-surface": "#1b1d0f",
                    "on-error-container": "#93000a",
                    "surface-container-lowest": "#ffffff",
                    "primary-fixed-dim": "#e5beb4",
                    "error": "#ba1a1a",
                    "secondary-container": "#e1e1c8",
                    "inverse-primary": "#e5beb4",
                    "surface-tint": "#765750",
                    "secondary-fixed-dim": "#c7c8b0",
                    "on-secondary-fixed": "#1b1d0d",
                    "outline": "#78776e",
                    "inverse-on-surface": "#f2f2db",
                    "on-primary": "#ffffff",
                    "on-tertiary-fixed-variant": "#4f434f",
                    "on-secondary": "#ffffff",
                    "on-primary-container": "#4e342d",
                    "on-background": "#1b1d0f",
                    "error-container": "#ffdad6",
                    "on-primary-fixed": "#2c1610",
                    "on-tertiary-container": "#433742",
                    "on-error": "#ffffff",
                    "on-secondary-container": "#636450",
                    "on-secondary-fixed-variant": "#464836",
                    "surface-container-low": "#f5f5de",
                    "surface": "#fbfbe4",
                    "on-primary-fixed-variant": "#5c4039",
                    "primary-container": "#c19c93",
                    "inverse-surface": "#303222",
                    "tertiary-fixed-dim": "#d3c1d0",
                    "secondary-fixed": "#e4e4cb",
                    "surface-container": "#efefd9",
                    "surface-container-high": "#e9ead3",
                    "secondary": "#A5A68F",
                    "outline-variant": "#c8c7bc",
                    "surface-variant": "#e4e4ce",
                    "on-surface-variant": "#47473f",
                    "on-tertiary-fixed": "#221823",
                    "on-tertiary": "#ffffff",
                    "tertiary-fixed": "#efddec",
                    "tertiary-container": "#b0a0ae",
                    "surface-container-highest": "#e4e4ce",
                    "surface-bright": "#fbfbe4"
            },
            "borderRadius": {
                    "DEFAULT": "0.25rem",
                    "lg": "0.5rem",
                    "xl": "0.75rem",
                    "full": "9999px"
            },
            "fontFamily": {
                    "headline": ["Newsreader", "serif"],
                    "body": ["Manrope", "sans-serif"],
                    "label": ["Manrope", "sans-serif"]
            }
          },
        }
      }
    </script>
<style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        body { font-family: 'Manrope', sans-serif; }
        .serif-italic { font-family: 'Newsreader', serif; font-style: italic; }
        .serif-bold { font-family: 'Newsreader', serif; font-weight: 700; }
        .glass-nav { background: rgba(251, 251, 228, 0.8); backdrop-filter: blur(12px); }
    </style>
</head>
<body class="bg-background text-on-background selection:bg-primary-container selection:text-on-primary-container">
<!-- TopNavBar -->
<nav class="sticky top-0 z-50 w-full bg-[#fbfbe4]/80 backdrop-blur-md dark:bg-stone-900/80">
<div class="flex justify-between items-center w-full px-8 py-4 max-w-screen-2xl mx-auto">
<div class="text-2xl font-serif font-bold text-secondary dark:text-primary uppercase tracking-widest">
                Mbah Bibit
            </div>
<div class="hidden md:flex gap-8 items-center">
<a class="text-secondary dark:text-primary border-b border-primary pb-1 font-serif italic tracking-tight transition-colors duration-300" href="#">Bunga Segar</a>
<a class="text-secondary/80 dark:text-secondary font-sans font-medium hover:text-primary transition-colors duration-300" href="#">Peralatan Pernikahan</a>
<a class="text-secondary/80 dark:text-secondary font-sans font-medium hover:text-primary transition-colors duration-300" href="#">Alat-alat Kematian</a>
</div>
<div class="flex items-center gap-6">
<div class="relative hidden sm:block">
<input class="bg-surface-variant border-none rounded-full px-6 py-2 text-sm focus:ring-1 focus:ring-primary w-64 transition-all duration-300" placeholder="Cari Koleksi..." type="text"/>
</div>
<button class="text-secondary scale-95 duration-200">
<span class="material-symbols-outlined" data-icon="shopping_bag">shopping_bag</span>
</button>
</div>
</div>
</nav>
<main class="max-w-screen-2xl mx-auto px-6 py-12 space-y-24">
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
<button class="bg-primary text-white px-8 py-4 rounded-full font-label font-bold text-sm tracking-widest uppercase hover:opacity-90 transition-all flex items-center gap-2 shadow-lg shadow-primary/20">
                        Jelajahi Katalog <span class="material-symbols-outlined text-sm" data-icon="arrow_forward">arrow_forward</span>
</button>
</div>
</div>
<div class="md:col-span-5 relative">
<div class="aspect-[4/5] rounded-3xl overflow-hidden shadow-2xl rotate-2 hover:rotate-0 transition-transform duration-700 bg-surface-container-high">
<img class="w-full h-full object-cover" data-alt="Vintage botanical illustration style photo of a lush bouquet featuring white lilies and deep green ferns against a parchment background" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBdJ1WTVQG8JjZilHrp3H_Ye1W0tHQ01I0QNLXojfAWeqb1VWVsdjJRRxvrmdJroaxmTi11Qb9gw931KJDpPYlrmXqwbLhbRUgbcDM1KENNF7Eoz4_wVerFllvUaQl3WTUBkTZG_-6LpMAfKIsM7vBOjcTPEf0V8jVAHVIMKtqDGP_m8DwR43t1GzCWnA9eT89aDAk_ZtTsNec4s2rySqguUUVUQEzan2U4yMLPrUzrWhEgcw6cfU1_IdDCLFKOu_l6YmIk38Y1YzA"/>
</div>
<div class="absolute -bottom-8 -left-8 bg-surface-container-highest p-6 rounded-2xl shadow-xl max-w-[200px] -rotate-3">
<p class="serif-italic text-secondary text-xl">Specimen 01: Bunga Sedap Malam</p>
<p class="text-xs text-secondary mt-2">Polianthes tuberosa. The fragrance of evening ceremonies.</p>
</div>
</div>
</header>
<!-- New Arrivals: The Specimen Gallery -->
<section class="space-y-12">
<div class="flex justify-between items-end border-b border-outline-variant pb-6">
<div class="space-y-2">
<h2 class="font-headline text-4xl text-on-surface">Koleksi Terbaru</h2>
<p class="text-secondary font-label">Tangkapan Musim Semi &amp; Perangkat Upacara</p>
</div>
<a class="text-primary font-label font-bold flex items-center gap-1 hover:underline" href="#">
                    Lihat Semua <span class="material-symbols-outlined" data-icon="north_east">north_east</span>
</a>
</div>
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-12">
<!-- Product Card 1 -->
<div class="group space-y-6">
<div class="aspect-[3/4] rounded-2xl overflow-hidden bg-surface-container-high relative">
<img class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110" data-alt="Artistic close up of an ornate Javanese wedding kris with intricate gold details and jasmine flower garland" src="https://lh3.googleusercontent.com/aida-public/AB6AXuD2BOUHeNF3U0P1OFeqThs6wb-z2Igo_e31oOQdSt1I-csYu0cU9279YUukFJRAiDPcNpWCnqFngtHoS_4QW2vag6iCMpnpCvvlMBgPv3HF0VqghNTPQf1UdcOq8ec1P4oKlwsXinGwitTPsPQLKtyVbZqPPJN1Ogw8Y2j3vXVjL1bFyKpyFHB-jwySwRVRkBijENr3SBctAkjjxelaUuHO3EQY9Ts43wtY3mI3lHCjsTMcAH1HnA3a76aDnaKftgGzjfUcMZq27UE"/>
<div class="absolute top-4 right-4 bg-background/90 backdrop-blur px-3 py-1 rounded-full text-[10px] font-bold tracking-widest uppercase text-primary">PERNIKAHAN</div>
</div>
<div class="space-y-2">
<div class="flex justify-between items-baseline">
<h3 class="font-headline text-2xl group-hover:text-primary transition-colors">Roncean Melati Pengantin</h3>
<span class="font-headline text-xl text-primary font-bold">Rp 450.000</span>
</div>
<p class="text-sm text-on-surface-variant leading-relaxed">Specimen #JW-09: Traditional hand-woven jasmine garlands for the bride, crafted with fresh buds picked at dawn.</p>
<div class="flex gap-2 pt-2">
<span class="bg-surface-container px-3 py-1 rounded text-[10px] text-secondary font-bold uppercase">Fresh Stock</span>
<span class="bg-surface-container px-3 py-1 rounded text-[10px] text-secondary font-bold uppercase">Custom Fit</span>
</div>
</div>
</div>
<!-- Product Card 2 -->
<div class="group space-y-6 mt-8 lg:mt-16">
<div class="aspect-[3/4] rounded-2xl overflow-hidden bg-surface-container-high relative">
<img class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110" data-alt="A minimalist funeral floral arrangement with white lilies and eucalyptus leaves in a ceramic vase" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBkQdQi8THt4xav-FYUcbCUwxIIDEiY13bowbb0YOBXite67ROGk_FP9Uih5DWyYSrMziAagNxsSeZkNOO4IBy7ObjM7O7fPplN4oTX_8i-Xsx5uAa9mxspNgBSQMdunntDgQP4It-9IgOcSxAROf3DiMjqgLziPBhwGKcn8CX1N3SE_YtS7X4SSfctzWrwYa2MO0QQRZo9O7wlFh5D5VVpjpMPS-s8adgFbJN4flAp2ZT2Ala1UZpaSWVDhOeblxevLNcrqQEzK6g"/>
<div class="absolute top-4 right-4 bg-background/90 backdrop-blur px-3 py-1 rounded-full text-[10px] font-bold tracking-widest uppercase text-primary">KEMATIAN</div>
</div>
<div class="space-y-2">
<div class="flex justify-between items-baseline">
<h3 class="font-headline text-2xl group-hover:text-primary transition-colors">Karangan Bunga Duka Cita</h3>
<span class="font-headline text-xl text-primary font-bold">Rp 850.000</span>
</div>
<p class="text-sm text-on-surface-variant leading-relaxed">Specimen #FL-22: A dignified tribute of pure lilies and white roses, designed to offer silent solace in moments of grief.</p>
<div class="flex gap-2 pt-2">
<span class="bg-surface-container px-3 py-1 rounded text-[10px] text-secondary font-bold uppercase">Archival Grade</span>
</div>
</div>
</div>
<!-- Product Card 3 -->
<div class="group space-y-6">
<div class="aspect-[3/4] rounded-2xl overflow-hidden bg-surface-container-high relative">
<img class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110" data-alt="Exotic rare orchids with deep purple petals and intricate vein patterns displayed in a laboratory glass vase" src="https://lh3.googleusercontent.com/aida-public/AB6AXuAbXtdeTpzWJr9x8ElL__HMmazdJOOsVLZya7TG-1l13oBYKbhMlWKg8UzOXahs0IMpCQMAQ96XvbV09mSuM-aSmiNMKkSIdCZ6Cgq6I5IxWBO2uEAmKcvEzdwXi25W2L-mmLTGr5h1F0d-AJ1nP8ulMr2yhpLft2NRfrVNW0S0fZFBztdauy5_KdPVC5HOSQjC2JOxTfrbDDa-xWrenNmOVo_-eFZxRNmVxbui35cwMuILWlH5iHfl8vrJhlzLBeMcxeJNDVnQPIY"/>
<div class="absolute top-4 right-4 bg-background/90 backdrop-blur px-3 py-1 rounded-full text-[10px] font-bold tracking-widest uppercase text-primary">BUNGA SEGAR</div>
</div>
<div class="space-y-2">
<div class="flex justify-between items-baseline">
<h3 class="font-headline text-2xl group-hover:text-primary transition-colors">Anggrek Bulan Ungu</h3>
<span class="font-headline text-xl text-primary font-bold">Rp 1.200.000</span>
</div>
<p class="text-sm text-on-surface-variant leading-relaxed">Specimen #OR-04: Rare deep-purple moon orchid, ethically sourced from the highlands. High endurance and vibrant pigment.</p>
<div class="flex gap-2 pt-2">
<span class="bg-surface-container px-3 py-1 rounded text-[10px] text-secondary font-bold uppercase">Rare Find</span>
<span class="bg-surface-container px-3 py-1 rounded text-[10px] text-secondary font-bold uppercase">Vase Included</span>
</div>
</div>
</div>
</div>
</section>
<!-- Botanical Tools: Archive Aesthetic -->
<section class="bg-surface-container-low rounded-[3rem] p-12 lg:p-24 relative overflow-hidden">
<div class="absolute top-0 right-0 opacity-10 pointer-events-none">
<span class="material-symbols-outlined text-[30rem]" data-icon="eco">eco</span>
</div>
<div class="relative grid grid-cols-1 md:grid-cols-2 gap-16 items-center">
<div class="space-y-8">
<div class="space-y-4">
<h2 class="font-headline text-5xl text-secondary">Peralatan Perawatan Botanical</h2>
<p class="text-secondary font-label leading-relaxed">Tools for the serious collector. Each piece is crafted for precision, durability, and a tactile connection to the Earth.</p>
</div>
<ul class="space-y-6">
<li class="flex gap-4 items-start">
<span class="material-symbols-outlined text-primary font-bold" data-icon="architecture">architecture</span>
<div>
<h4 class="font-bold text-on-surface">Precision Pruning Scissors</h4>
<p class="text-sm text-on-surface-variant">Forged steel for clean, botanical-grade cuts that preserve stem health.</p>
</div>
</li>
<li class="flex gap-4 items-start">
<span class="material-symbols-outlined text-primary" data-icon="humidity_percentage">humidity_percentage</span>
<div>
<h4 class="font-bold text-on-surface">Copper Mist Atomizer</h4>
<p class="text-sm text-on-surface-variant">Ultrafine hydration for delicate orchid species and ferns.</p>
</div>
</li>
<li class="flex gap-4 items-start">
<span class="material-symbols-outlined text-primary" data-icon="book_5">book_5</span>
<div>
<h4 class="font-bold text-on-surface">The Mbah Bibit Field Guide</h4>
<p class="text-sm text-on-surface-variant">Our signature handbook on Javanese flora care and ritual meanings.</p>
</div>
</li>
</ul>
<button class="border border-primary text-primary px-8 py-3 rounded-full font-label font-bold text-sm tracking-widest uppercase hover:bg-primary hover:text-white transition-all">
                        Eksplor Peralatan
                    </button>
</div>
<div class="grid grid-cols-2 gap-4">
<div class="aspect-square rounded-2xl overflow-hidden shadow-lg transform translate-y-8">
<img class="w-full h-full object-cover" data-alt="Professional gardener's hand tools including a vintage copper watering can and wooden handled shears on a garden bench" src="https://lh3.googleusercontent.com/aida-public/AB6AXuAaDNt4GnlqCySYK2HT8h8A-Jhx3ACuOHCyuNaAp7NiPP7tYEvCK5JpAkNKWvbPL3LWAVXCE8yOUGP2h8pipZjZrwxKOsqee3TXP3MVMlIfCbPObU90eiyT76v9NtOqRcgZsVMhUhoyuZxVHthkBrdU4g71Xu5NDj9xooM0h3PilXToTl7HIuCPQmtvjqNyusXAn4m6CwhesC4_7m0wHl9803OTeFpokJmATFvKSkLn1qg7HH4bgVKalLJuuSdqxziRCsvg8M9_3MA"/>
</div>
<div class="aspect-square rounded-2xl overflow-hidden shadow-lg">
<img class="w-full h-full object-cover" data-alt="Macro photo of fresh potting soil being mixed with compost in a ceramic planter at a botanical studio" src="https://lh3.googleusercontent.com/aida-public/AB6AXuATGQcgDLoMK9appAT0Ej9fz6nXnlWpV0BmN1E74rVQipdxhkHJz6G_Y-Q2Kc0E-jJjcfQkomwLrd0HceUWqSwWJ5AZ2KboTnMM9OIvay-IEdS1xAyLnNO40pqMZDf15Q7iU1vtql3YmurMyBClvfyeFVdc3tSl68hQ0tdrWeMctvIJ_64KFSQx8YdiQPoRX2NPc-ZQAjBaMogy0DpJtUff0EGzCdPy18RpU95oSguMS4YBnF4_022WXbn_uqP8gCn6oXipp9caAxc"/>
</div>
</div>
</div>
</section>
<!-- Bento Category Grid -->
<section class="space-y-12">
<h2 class="font-headline text-4xl text-center text-on-surface">Jelajahi Berdasarkan Kategori</h2>
<div class="grid grid-cols-1 md:grid-cols-4 grid-rows-2 gap-6 h-[800px] md:h-[600px]">
<!-- Bunga Segar -->
<div class="md:col-span-2 md:row-span-2 group relative rounded-3xl overflow-hidden bg-secondary-container">
<img class="w-full h-full object-cover transition-transform duration-1000 group-hover:scale-105" data-alt="Vibrant field of yellow and orange wild flowers under a bright morning sun with soft bokeh background" src="https://lh3.googleusercontent.com/aida-public/AB6AXuAQn9fi5WmmVB-JaIIWyGfbuhBICc1WpzRwDCZszFla8u8_YMbPKfEcrCz-GrdqNCtgGrjk9Z4YQ9dIkvWyGe3iG9oBjU-aY44aEf7ix4fiOGTQ7WPpNI0xTHSRf4s8uCLoOWCqpvndSdhJkRybp9B5mMVUFT5y9-G9_7l_88kIgFIalbbucpQeW4l0Hrhw2YsTFy13Mmopjnj8MCdzRpx0rdVRP8YKvuZMnvr9KpBsNfHEBx7WBNgH8Rv-5rTNzUE3ElMqSTDsAdA"/>
<div class="absolute inset-0 bg-gradient-to-t from-primary/80 to-transparent flex flex-col justify-end p-8 text-on-primary opacity-0 group-hover:opacity-100 transition-opacity duration-500">
<h3 class="font-headline text-3xl">Bunga Segar</h3>
<p class="font-label text-sm opacity-80 mt-2">The ephemeral beauty of morning-picked blooms.</p>
<button class="mt-4 w-fit bg-on-primary text-primary px-6 py-2 rounded-full font-bold text-xs">Jelajahi</button>
</div>
<div class="absolute top-8 left-8">
<h3 class="font-headline text-3xl text-on-secondary-container drop-shadow-sm group-hover:hidden transition-all">Bunga Segar</h3>
</div>
</div>
<!-- Pernikahan -->
<div class="md:col-span-2 md:row-span-1 group relative rounded-3xl overflow-hidden bg-primary-fixed">
<img class="w-full h-full object-cover transition-transform duration-1000 group-hover:scale-105" data-alt="Elegant wedding table setting with pastel floral centerpieces and white linen under warm ambient lighting" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDNLKVP03Eqo-ktg_9mV6w2j8FSQzZOBhLQduaTkhYxrtRMSxYoL82zsnTqI9TAlvZXNWhVxLNe-dMharMXFwiEcH56YQ8sEpG2R1sgniG-wpYTNIubIVHFVTLWT0i5weF6d-tE1bfQvyu0pV3BtXpy6krln61lbkUBwdz4igCzotdPdQ5euZnzc7Xu4uEgerid5vW1Pa2d2xDDfBqLcWa9xUrUprWUUUKwIUCTGilsv9XX_p4hnpTIPs63ki2qiRyjTxp2o0KJ_dA"/>
<div class="absolute inset-0 bg-gradient-to-t from-primary/80 to-transparent flex flex-col justify-end p-8 text-on-primary opacity-0 group-hover:opacity-100 transition-opacity duration-500">
<h3 class="font-headline text-3xl">Peralatan Pernikahan</h3>
<p class="font-label text-sm opacity-80 mt-2">Sacred aesthetics for your union.</p>
</div>
<div class="absolute top-8 left-8">
<h3 class="font-headline text-3xl text-on-primary-fixed drop-shadow-sm group-hover:hidden transition-all">Pernikahan</h3>
</div>
</div>
<!-- Kematian -->
<div class="md:col-span-1 md:row-span-1 group relative rounded-3xl overflow-hidden bg-tertiary-container">
<img class="w-full h-full object-cover transition-transform duration-1000 group-hover:scale-105" data-alt="Moody still life of a single white lily in a stone vase against a dark grey textured wall" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCYjdbVuzwNutUNlGqj1bism_CivPDqbcvQS6EeXpV_Y3n-Jq0HUeosprYsXhpM2-dNvTcH1uIwKuwgbROwZfGcgzKvu_nNqKZ419TJ2YP2hLg4dXicmodTJUUliUzjvguPyDm4Bmw4P-2BsS3cgRJeOnkZPC_bHcheeWteB1D4B1-TCMxyH25stE9-71WlPJZZmtrqg1l26yFRgo4OluJ4WzGr3efFXbKx_o7JR2GqdF-zVN5g_G1W03r_uwOm9TGo1zwpazTiUwE"/>
<div class="absolute inset-0 bg-gradient-to-t from-primary/80 to-transparent flex flex-col justify-end p-6 text-on-primary opacity-0 group-hover:opacity-100 transition-opacity duration-500">
<h3 class="font-headline text-xl">Duka Cita</h3>
</div>
<div class="absolute top-6 left-6">
<h3 class="font-headline text-xl text-on-tertiary-container group-hover:hidden">Kematian</h3>
</div>
</div>
<!-- Tools -->
<div class="md:col-span-1 md:row-span-1 group relative rounded-3xl overflow-hidden bg-surface-dim">
<img class="w-full h-full object-cover transition-transform duration-1000 group-hover:scale-105" data-alt="Artistic composition of botanical tools, twine, and old parchment paper on a rustic wooden table" src="https://lh3.googleusercontent.com/aida-public/AB6AXuAml7WuepMtXTsOvmnZKhDpGRGlnO-PP4uOrlzcNWY1TqSrznjm3wA3cG9hhtxko7xA1bdblD44pt9tUdNNmXqXfM5q-INHV4xNhwTLz1EcXHfYjmQF4YkAZSdml06mSaZOLF9PVI-WcWkjT-bK8qDq0PyYIe3-z8gEy_94qi9VnVoe_9L-89Vnl6XaeoIlnS-06pQRxU82etC08XB4ryaZeWncbBgSjb2jtuHRMSLG7U2Dhtyle5R0Y_wROicLnLExEE7qpKAFjf4"/>
<div class="absolute inset-0 bg-gradient-to-t from-primary/80 to-transparent flex flex-col justify-end p-6 text-on-primary opacity-0 group-hover:opacity-100 transition-opacity duration-500">
<h3 class="font-headline text-xl">Arsip &amp; Alat</h3>
</div>
<div class="absolute top-6 left-6">
<h3 class="font-headline text-xl text-on-surface group-hover:hidden">Alat</h3>
</div>
</div>
</div>
</section>
</main>
<!-- Footer -->
<footer class="bg-[#FAFAE3] dark:bg-stone-950 text-secondary dark:text-primary py-12 px-12 border-t border-secondary/10 mt-24">
<div class="grid grid-cols-1 md:grid-cols-4 gap-12 max-w-screen-2xl mx-auto">
<div class="space-y-4">
<div class="text-lg font-serif font-semibold">Toko Bunga Mbah Bibit</div>
<p class="font-sans text-sm tracking-wide text-secondary/80">Preserving the ritual essence of nature since 1978. Every specimen tells a story of heritage and respect.</p>
</div>
<div class="space-y-4">
<h4 class="font-label font-bold uppercase text-[10px] tracking-[0.2em]">Navigation</h4>
<ul class="font-sans text-sm space-y-2">
<li><a class="text-[#5e604c] hover:opacity-70 transition-colors" href="#">Bunga Segar</a></li>
<li><a class="text-[#5e604c] hover:opacity-70 transition-colors underline" href="#">Archives</a></li>
<li><a class="text-[#5e604c] hover:opacity-70 transition-colors" href="#">Care Guides</a></li>
</ul>
</div>
<div class="space-y-4">
<h4 class="font-label font-bold uppercase text-[10px] tracking-[0.2em]">Contact</h4>
<ul class="font-sans text-sm space-y-2">
<li class="text-[#5e604c]">Solo, Jawa Tengah</li>
<li class="text-[#5e604c]">toko@mbahbibit.com</li>
<li class="text-[#5e604c]">+62 812 3456 7890</li>
</ul>
</div>
<div class="space-y-4">
<h4 class="font-label font-bold uppercase text-[10px] tracking-[0.2em]">Newsletter</h4>
<div class="flex gap-2">
<input class="bg-surface-container border-none rounded-lg px-4 py-2 text-xs focus:ring-1 focus:ring-primary w-full" placeholder="Email Anda" type="email"/>
<button class="bg-primary text-on-primary px-4 py-2 rounded-lg text-[10px] font-bold uppercase">Join</button>
</div>
</div>
</div>
<div class="max-w-screen-2xl mx-auto mt-12 pt-8 border-t border-[#5e604c]/5 flex flex-col md:flex-row justify-between items-center gap-4">
<p class="font-sans text-xs tracking-wide text-[#5e604c] opacity-60">© 2024 Toko Bunga Mbah Bibit. Curating Heritage through Nature.</p>
<div class="flex gap-6">
<a class="material-symbols-outlined text-lg" data-icon="share" href="#">share</a>
<a class="material-symbols-outlined text-lg" data-icon="photo_camera" href="#">photo_camera</a>
<a class="material-symbols-outlined text-lg" data-icon="mail" href="#">mail</a>
</div>
</div>
</footer>
<!-- Floating Contact FAB (Suppressed on most pages, but kept here for landing context) -->
<button class="fixed bottom-8 right-8 bg-primary text-white p-4 rounded-full shadow-2xl hover:scale-105 transition-transform z-40 shadow-primary/40">
<span class="material-symbols-outlined" data-icon="chat_bubble">chat_bubble</span>
</button>
</body></html>