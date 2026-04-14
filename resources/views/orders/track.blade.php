@extends('layouts.front')

@section('title', 'Lacak Pesanan — Mbah Bibit')

@section('content')

<div class="w-full border-t border-secondary/20"></div>

<div class="max-w-screen-xl mx-auto">

    {{-- === MASTHEAD === --}}
    <div class="grid grid-cols-12 border-b border-secondary/20">
        <div class="col-span-12 md:col-span-3 border-b md:border-b-0 md:border-r border-secondary/20 px-8 py-6 flex items-center">
            <div>
                <p class="text-[9px] font-black uppercase tracking-[0.3em] text-secondary/40">Mbah Bibit</p>
                <p class="text-[9px] font-black uppercase tracking-[0.3em] text-secondary/40 mt-0.5">Lacak Pesanan</p>
            </div>
        </div>
        <div class="col-span-12 md:col-span-9 px-8 md:px-16 py-12">
            <h1 class="font-headline text-[clamp(3rem,10vw,7rem)] text-secondary leading-none tracking-tight">
                Status<br><span class="serif-italic text-primary">Pesanan</span>
            </h1>
        </div>
    </div>

    {{-- === BODY === --}}
    <div class="grid grid-cols-12">

        {{-- LEFT: Info / Process --}}
        <div class="col-span-12 md:col-span-4 border-b md:border-b-0 md:border-r border-secondary/20 flex flex-col">
            <div class="px-8 py-12 space-y-10 flex-1">
                <p class="text-secondary/70 leading-[1.9] text-[15px]">
                    Masukkan nomor pesanan dan email yang Anda gunakan saat berbelanja untuk melihat status terkini pengiriman botanikal Anda.
                </p>

                <div class="space-y-0">
                    <div class="py-6 border-t border-secondary/10 flex items-start gap-5">
                        <span class="text-[11px] font-black uppercase tracking-[0.2em] text-secondary/30 w-8 shrink-0 mt-0.5">01</span>
                        <div>
                            <p class="text-sm font-bold text-secondary mb-1">Pembayaran Terverifikasi</p>
                            <p class="text-[12px] text-secondary/50 leading-relaxed">Pesanan diproses setelah pembayaran dikonfirmasi sistem.</p>
                        </div>
                    </div>
                    <div class="py-6 border-t border-secondary/10 flex items-start gap-5">
                        <span class="text-[11px] font-black uppercase tracking-[0.2em] text-secondary/30 w-8 shrink-0 mt-0.5">02</span>
                        <div>
                            <p class="text-sm font-bold text-secondary mb-1">Kurasi & Persiapan</p>
                            <p class="text-[12px] text-secondary/50 leading-relaxed">Tim Mbah Bibit merangkai bunga segar sesuai pesanan Anda.</p>
                        </div>
                    </div>
                    <div class="py-6 border-t border-secondary/10 flex items-start gap-5">
                        <span class="text-[11px] font-black uppercase tracking-[0.2em] text-secondary/30 w-8 shrink-0 mt-0.5">03</span>
                        <div>
                            <p class="text-sm font-bold text-secondary mb-1">Dikirim ke Tujuan</p>
                            <p class="text-[12px] text-secondary/50 leading-relaxed">Kurir mengantarkan pesanan Anda dengan penanganan khusus.</p>
                        </div>
                    </div>
                    <div class="py-6 border-t border-secondary/10"></div>
                </div>
            </div>

            <div class="border-t border-secondary/20 px-8 py-5">
                <p class="text-[10px] text-secondary/40 uppercase tracking-widest">Solo & Sekitarnya · Est. 1978</p>
            </div>
        </div>

        {{-- RIGHT: Form & Result --}}
        <div class="col-span-12 md:col-span-8 px-8 md:px-16 py-12 space-y-0">

            @if(session('error'))
            <div class="mb-10 flex items-center gap-4 border-l-4 border-primary pl-6 py-4">
                <span class="material-symbols-outlined text-primary">error_outline</span>
                <p class="text-sm text-secondary/80">{{ session('error') }}</p>
            </div>
            @endif

            <form action="{{ route('orders.track') }}" method="GET" class="space-y-0">

                {{-- Field 1: Order ID --}}
                <div class="py-8 border-b border-secondary/15 group focus-within:border-secondary/50 transition-colors">
                    <label class="block text-[9px] font-black uppercase tracking-[0.3em] text-secondary/30 mb-3 group-focus-within:text-secondary/60 transition-colors">Nomor Pesanan</label>
                    <input type="text" name="order_id" value="{{ request('order_id') }}" required autocomplete="off"
                           class="w-full bg-transparent border-none p-0 text-2xl md:text-3xl font-headline text-secondary placeholder:text-secondary/15 focus:ring-0 focus:outline-none"
                           placeholder="#ORD-12345">
                </div>

                {{-- Field 2: Email --}}
                <div class="py-8 border-b border-secondary/15 group focus-within:border-secondary/50 transition-colors">
                    <label class="block text-[9px] font-black uppercase tracking-[0.3em] text-secondary/30 mb-3 group-focus-within:text-secondary/60 transition-colors">Email Pembelian</label>
                    <input type="email" name="email" value="{{ request('email') }}" required autocomplete="off"
                           class="w-full bg-transparent border-none p-0 text-2xl md:text-3xl font-headline text-secondary placeholder:text-secondary/15 focus:ring-0 focus:outline-none"
                           placeholder="nama@email.com">
                </div>

                {{-- Submit Row --}}
                <div class="pt-10 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-6">
                    <p class="text-[10px] uppercase tracking-widest text-secondary/30 leading-relaxed">
                        Nomor pesanan tersedia di<br>riwayat akun atau email konfirmasi Anda.
                    </p>
                    <button type="submit"
                            class="group inline-flex items-center gap-4 bg-secondary text-[#FAFAE3] px-10 py-5 uppercase tracking-widest text-[11px] font-black hover:bg-primary transition-colors duration-300 shrink-0">
                        Lacak Pesanan
                        <span class="material-symbols-outlined text-lg transition-transform duration-300 group-hover:translate-x-1">arrow_forward</span>
                    </button>
                </div>
            </form>

            {{-- === RESULT SECTION === --}}
            @if(isset($order) && $order)
            <div class="mt-16 space-y-0 border-t-2 border-secondary/20 pt-12">

                {{-- Result Header --}}
                <div class="flex items-baseline justify-between mb-10">
                    <div>
                        <p class="text-[9px] font-black uppercase tracking-[0.3em] text-secondary/30 mb-2">Ditemukan</p>
                        <h2 class="font-headline text-4xl text-secondary">
                            #ORD-{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}
                        </h2>
                    </div>
                    @php
                        $statusColors = [
                            'pending'    => 'text-amber-600 border-amber-300',
                            'processing' => 'text-blue-600 border-blue-300',
                            'shipped'    => 'text-purple-600 border-purple-300',
                            'delivered'  => 'text-emerald-600 border-emerald-300',
                            'cancelled'  => 'text-red-500 border-red-300',
                        ];
                        $sc = $statusColors[$order->status] ?? 'text-secondary border-secondary/30';
                    @endphp
                    <span class="inline-block border px-5 py-2 text-[10px] font-black uppercase tracking-widest {{ $sc }}">
                        {{ ucfirst($order->status) }}
                    </span>
                </div>

                {{-- Status Grid --}}
                <div class="grid grid-cols-2 gap-0 border border-secondary/15">
                    <div class="p-6 border-b border-secondary/15">
                        <p class="text-[9px] font-black uppercase tracking-[0.25em] text-secondary/30 mb-2">Status Pembayaran</p>
                        <p class="font-headline text-xl text-secondary">
                            {{ ucfirst($order->pembayaran->status_pembayaran ?? 'Menunggu') }}
                        </p>
                    </div>
                    <div class="p-6 border-b border-l border-secondary/15">
                        <p class="text-[9px] font-black uppercase tracking-[0.25em] text-secondary/30 mb-2">Status Pengiriman</p>
                        <p class="font-headline text-xl text-secondary">
                            {{ $order->pengiriman ? ucfirst($order->pengiriman->status_pengiriman) : 'Menyiapkan' }}
                        </p>
                    </div>
                    <div class="px-6 py-8 border-b border-secondary/15">
                        <p class="text-[9px] font-black uppercase tracking-[0.25em] text-secondary/30 mb-2">Petugas Kurir</p>
                        <p class="font-headline text-xl text-secondary">
                            {{ $order->pengiriman->assignedKurir->name ?? ($order->pengiriman->kurir ?? '—') }}
                        </p>
                        @php
                            $kurirPhone = $order->pengiriman->assignedKurir->no_hp ?? ($order->pengiriman->no_hp_kurir ?? null);
                        @endphp
                        @if($kurirPhone)
                            <p class="text-[11px] text-primary font-bold mt-1">{{ $kurirPhone }}</p>
                        @endif
                    </div>
                    <div class="p-6 border-b border-l border-secondary/15">
                        <p class="text-[9px] font-black uppercase tracking-[0.25em] text-secondary/30 mb-2">No. Resi</p>
                        <p class="font-headline text-xl font-mono text-secondary tracking-wider">
                            {{ $order->pengiriman->no_resi ?? '—' }}
                        </p>
                    </div>
                    <div class="p-6">
                        <p class="text-[9px] font-black uppercase tracking-[0.25em] text-secondary/30 mb-2">Tanggal Dikirim</p>
                        <p class="font-headline text-xl text-secondary">
                            {{ $order->pengiriman?->tanggal_kirim ? \Carbon\Carbon::parse($order->pengiriman->tanggal_kirim)->translatedFormat('d F Y') : '—' }}
                        </p>
                    </div>
                    <div class="p-6 border-l border-secondary/15">
                        <p class="text-[9px] font-black uppercase tracking-[0.25em] text-secondary/30 mb-2">Estimasi Tiba</p>
                        <p class="font-headline text-xl text-secondary">
                            {{ $order->pengiriman?->tanggal_terima ? \Carbon\Carbon::parse($order->pengiriman->tanggal_terima)->translatedFormat('d F Y') : '—' }}
                        </p>
                    </div>
                </div>

                {{-- === LIVE TRACKING MAP === --}}
                @if($order->pengiriman && $order->pengiriman->assignedKurir && $order->pengiriman->status_pengiriman === 'dikirim')
                <div class="mt-12 space-y-6">
                    <div class="flex items-center justify-between">
                        <p class="text-[9px] font-black uppercase tracking-[0.3em] text-secondary/30">Live Tracking Kurir</p>
                        <div id="tracking-status-container" class="flex items-center gap-2 transition-opacity duration-300">
                            <span class="flex h-2 w-2 relative">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                            </span>
                            <span id="tracking-status-text" class="text-[9px] font-black uppercase tracking-widest text-emerald-600">Pelacakan Aktif</span>
                        </div>
                    </div>
                    <div id="map" class="w-full h-[350px] border border-secondary/15 relative z-0">
                        {{-- Placeholder loading --}}
                        <div id="map-loader" class="absolute inset-0 bg-secondary/[0.02] flex items-center justify-center z-[1000]">
                            <p class="text-[10px] font-black uppercase tracking-widest text-secondary/20 animate-pulse">Memuat Peta Botani...</p>
                        </div>
                    </div>
                    <p id="last-update-text" class="text-[9px] text-secondary/40 text-right uppercase tracking-[0.2em]">—</p>
                </div>

                @push('scripts')
                <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
                <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const mapElement = document.getElementById('map');
                        if (!mapElement) return;

                        // Solo coordinates as fallback
                        let courierLat = -7.5666;
                        let courierLng = 110.8167;
                        
                        // Initialize Map
                        const map = L.map('map', {
                            scrollWheelZoom: false,
                            zoomControl: false
                        }).setView([courierLat, courierLng], 15);

                        L.control.zoom({ position: 'bottomright' }).addTo(map);

                        // Leaflet Grayscale Filter (Custom Style)
                        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                            attribution: '© OpenStreetMap contributors'
                        }).addTo(map);

                        // Custom Marker Icon
                        const kurirIcon = L.icon({
                            iconUrl: 'https://cdn-icons-png.flaticon.com/512/3063/3063822.png',
                            iconSize: [40, 40],
                            iconAnchor: [20, 40],
                            popupAnchor: [0, -40]
                        });

                        let marker = L.marker([courierLat, courierLng], { icon: kurirIcon }).addTo(map)
                                      .bindPopup('<p class="text-[10px] font-bold uppercase tracking-widest text-secondary">Posisi Kurir</p>')
                                      .openPopup();

                        // Polling Location
                        const orderId = "{{ $order->id }}";
                        const customerEmail = "{{ request('email') }}";
                        const statusContainer = document.getElementById('tracking-status-container');
                        const statusText = document.getElementById('tracking-status-text');
                        const lastUpdateText = document.getElementById('last-update-text');
                        const loader = document.getElementById('map-loader');

                        function updateLocation() {
                            fetch(`{{ route('orders.kurir-location', $order->id) }}?email=${customerEmail}`)
                                .then(res => res.json())
                                .then(data => {
                                    if (loader) loader.classList.add('hidden');
                                    
                                    if (data.latitude && data.longitude) {
                                        const newPos = [data.latitude, data.longitude];
                                        marker.setLatLng(newPos);
                                        map.panTo(newPos);
                                        
                                        statusContainer.classList.remove('opacity-30');
                                        statusText.textContent = 'Pelacakan Aktif';
                                        lastUpdateText.textContent = `Pembaruan Terakhir: ${data.last_update}`;
                                    } else {
                                        statusContainer.classList.add('opacity-30');
                                        statusText.textContent = 'Kurir Belum Mengaktifkan GPS';
                                    }
                                })
                                .catch(err => {
                                    console.error('Tracking Error:', err);
                                    statusContainer.classList.add('opacity-30');
                                    statusText.textContent = 'Kendala Koneksi';
                                });
                        }

                        // Initial call and then every 20 seconds
                        updateLocation();
                        setInterval(updateLocation, 20000);
                    });
                </script>
                @endpush
                @endif
            </div>
            @endif

        </div>
    </div>
</div>

<div class="w-full border-t border-secondary/20 mt-8"></div>

@endsection
