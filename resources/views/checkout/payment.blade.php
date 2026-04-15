@extends('layouts.front')

@section('title', 'Pembayaran Pesanan — Mbah Bibit')

@section('content')

{{-- === TOP RULE === --}}
<div class="w-full border-t border-secondary/20"></div>

<div class="max-w-screen-xl mx-auto min-h-screen">
    
    {{-- === MASTHEAD === --}}
    <div class="grid grid-cols-12 border-b border-secondary/20">
        {{-- Label col --}}
        <div class="col-span-12 md:col-span-3 border-b md:border-b-0 md:border-r border-secondary/20 px-8 py-6 flex items-center">
            <div>
                <p class="text-[9px] font-black uppercase tracking-[0.3em] text-secondary/40">Pembayaran Aman</p>
                <p class="text-[9px] font-black uppercase tracking-[0.3em] text-secondary/40 mt-0.5">Verifikasi Pesanan</p>
            </div>
        </div>
        {{-- Headline col --}}
        <div class="col-span-12 md:col-span-9 px-8 md:px-16 py-12 flex flex-col md:flex-row md:items-end justify-between gap-8">
            <h1 class="font-headline text-[clamp(2.5rem,6vw,4.5rem)] text-secondary leading-none tracking-tight">
                Instruksi<br><span class="serif-italic text-primary">Pembayaran</span>
            </h1>
            
            <p class="text-[10px] font-black uppercase tracking-[0.3em] text-secondary/30 mb-2">
                Batas Waktu: 24 Jam
            </p>
        </div>
    </div>

    {{-- === BODY === --}}
    <div class="grid grid-cols-12 min-h-[50vh]">
        
        {{-- LEFT: Transaction Identities --}}
        <div class="col-span-12 lg:col-span-5 border-b lg:border-b-0 md:border-r border-secondary/20">
            <div class="p-8 md:p-12 space-y-12">
                <div class="space-y-10">
                    <div>
                        <p class="text-[9px] font-black uppercase tracking-[0.3em] text-secondary/30 mb-8">Informasi Transaksi</p>
                        
                        <div class="grid grid-cols-1 border border-secondary/15">
                            <div class="p-6 border-b border-secondary/15 flex justify-between items-center">
                                <span class="text-[10px] text-secondary/40 uppercase tracking-widest">Reference ID</span>
                                <span class="font-mono text-sm font-bold text-secondary">#ORD-{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</span>
                            </div>
                            <div class="p-6 border-b border-secondary/15 flex justify-between items-center bg-secondary/[0.01]">
                                <span class="text-[10px] text-secondary/40 uppercase tracking-widest">Gateaway</span>
                                <span class="text-[10px] font-black uppercase tracking-widest text-secondary">Secured by Midtrans</span>
                            </div>
                            <div class="p-6 flex justify-between items-center">
                                <span class="text-[10px] text-secondary/40 uppercase tracking-widest">Tanggal Pesanan</span>
                                <span class="text-[10px] font-black uppercase tracking-widest text-secondary">{{ $order->created_at->format('d M Y') }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="pt-8 border-t border-secondary/10">
                        <p class="text-xs text-secondary/50 leading-relaxed italic">
                            Pesanan Anda akan mulai dirangkai oleh tim botanikal kami segera setelah pembayaran terverifikasi oleh sistem.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        {{-- RIGHT: Payment Action --}}
        <div class="col-span-12 lg:col-span-7 flex flex-col justify-center items-center p-12 md:p-24 space-y-12">
            
            <div class="text-center space-y-6">
                <p class="text-[10px] font-black uppercase tracking-[0.5em] text-secondary/40">Total Tagihan</p>
                <h2 class="font-headline text-[clamp(3.5rem,10vw,6rem)] text-primary leading-none">
                    Rp {{ number_format($order->total_harga, 0, ',', '.') }}
                </h2>
            </div>

            <div class="w-full max-w-sm space-y-8">
                <button id="pay-button" 
                        class="group w-full bg-secondary text-[#FAFAE3] py-8 uppercase tracking-[0.3em] text-[11px] font-black hover:bg-primary transition-all text-center flex items-center justify-center gap-4">
                    Selesaikan Pembayaran
                    <span class="material-symbols-outlined text-lg transition-transform group-hover:translate-x-1">payments</span>
                </button>

                <div class="flex flex-col items-center gap-4 py-8 border-t border-secondary/10 opacity-30">
                    <div class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-xs">shield_lock</span>
                        <p class="text-[9px] font-black uppercase tracking-[0.3em]">End-to-End Encryption</p>
                    </div>
                    <p class="text-[9px] font-bold uppercase tracking-[0.2em] text-center max-w-[200px]">
                        Midtrans SSL Verified Transaction System
                    </p>
                </div>
            </div>

            <div class="absolute bottom-8 right-12 hidden lg:block">
                 <p class="text-[9px] text-secondary/20 uppercase tracking-[0.4em] transform -rotate-90 origin-right">Toko Bunga Mbah Bibit · Est. 1978</p>
            </div>
        </div>
    </div>
</div>

<div class="w-full border-t border-secondary/20 mt-8"></div>

@push('scripts')
<script type="text/javascript"
        src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ config('midtrans.client_key') }}"></script>
        
<script type="text/javascript">
    function syncStatusAndRedirect(result) {
        fetch('{{ route("checkout.sync") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ transaction_id: result.transaction_id })
        }).then(() => {
            window.location.href = "{{ route('profile.index') }}"; 
        });
    }

    document.getElementById('pay-button').onclick = function(){
        snap.pay('{{ $snapToken }}', {
            onSuccess: function(result){
                alert("Berhasil! Sistem sedang memproses transaksi Anda."); 
                syncStatusAndRedirect(result);
            },
            onPending: function(result){
                alert("Berhasil! Menunggu Anda menyelesaikan pembayaran."); 
                syncStatusAndRedirect(result);
            },
            onError: function(result){
                alert("Pembayaran gagal!"); console.log(result);
            },
            onClose: function(){
                // alert('Anda menutup popup tanpa menyelesaikan pembayaran');
            }
        });
    };
</script>
@endpush
@endsection
