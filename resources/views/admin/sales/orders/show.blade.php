@extends('admin.layouts.app')
@section('title', 'Detail Order #' . $order->id)
@section('subtitle', 'Informasi lengkap pesanan')

@section('content')
<div class="space-y-6">
    <a href="{{ route('admin.orders.index') }}" class="inline-flex items-center gap-1 text-sm text-text-muted hover:text-accent-emerald transition-colors">
        <span class="material-symbols-outlined text-lg">arrow_back</span> Kembali ke Daftar Order
    </a>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Order Info --}}
        <div class="glass-card rounded-2xl p-6 space-y-4">
            <h3 class="font-semibold flex items-center gap-2 text-accent-emerald">
                <span class="material-symbols-outlined">info</span> Info Order
            </h3>
            <div class="space-y-3 text-sm">
                <div class="flex justify-between"><span class="text-text-muted">Order ID</span><span class="font-mono">#{{ $order->id }}</span></div>
                <div class="flex justify-between"><span class="text-text-muted">Status</span>
                    @php $colors = ['pending'=>'text-yellow-400','paid'=>'text-blue-400','shipped'=>'text-purple-400','completed'=>'text-emerald-400','cancelled'=>'text-red-400']; @endphp
                    <span class="font-medium {{ $colors[$order->status] ?? 'text-gray-400' }}">{{ ucfirst($order->status) }}</span>
                </div>
                <div class="flex justify-between"><span class="text-text-muted">Tanggal</span><span>{{ $order->created_at->format('d M Y H:i') }}</span></div>
                <div class="flex justify-between"><span class="text-text-muted">Total</span><span class="text-accent-gold font-bold text-lg">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</span></div>
            </div>
        </div>

        {{-- Customer Info --}}
        <div class="glass-card rounded-2xl p-6 space-y-4">
            <h3 class="font-semibold flex items-center gap-2 text-accent-rose">
                <span class="material-symbols-outlined">person</span> Info Customer
            </h3>
            <div class="space-y-3 text-sm">
                <div class="flex justify-between"><span class="text-text-muted">Nama</span><span>{{ $order->customer_name ?? '-' }}</span></div>
                <div class="flex justify-between"><span class="text-text-muted">Email</span><span>{{ $order->customer_email ?? '-' }}</span></div>
                <div class="flex justify-between"><span class="text-text-muted">Telepon</span><span>{{ $order->customer_phone ?? '-' }}</span></div>
                <div><span class="text-text-muted block mb-1">Alamat</span><span class="text-text-secondary">{{ $order->alamat_pengiriman ?? '-' }}</span></div>
            </div>
        </div>

        {{-- Payment & Shipping --}}
        <div class="space-y-6">
            @if($order->pembayaran)
            <div class="glass-card rounded-2xl p-6 space-y-3">
                <h3 class="font-semibold flex items-center gap-2 text-accent-gold text-sm">
                    <span class="material-symbols-outlined">payments</span> Pembayaran
                </h3>
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between"><span class="text-text-muted">Metode</span><span>{{ $order->pembayaran->metode_pembayaran }}</span></div>
                    <div class="flex justify-between"><span class="text-text-muted">Jumlah</span><span>Rp {{ number_format($order->pembayaran->jumlah_bayar, 0, ',', '.') }}</span></div>
                    <div class="flex justify-between"><span class="text-text-muted">Status</span>
                        <span class="{{ $order->pembayaran->status_pembayaran == 'paid' ? 'text-emerald-400' : 'text-yellow-400' }}">{{ ucfirst($order->pembayaran->status_pembayaran) }}</span>
                    </div>
                </div>
            </div>
            @endif

            @if($order->pengiriman)
            <div class="glass-card rounded-2xl p-6 space-y-3">
                <h3 class="font-semibold flex items-center gap-2 text-blue-400 text-sm">
                    <span class="material-symbols-outlined">local_shipping</span> Pengiriman
                </h3>
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between"><span class="text-text-muted">Kurir</span><span>{{ $order->pengiriman->kurir ?? '-' }}</span></div>
                    <div class="flex justify-between"><span class="text-text-muted">Resi</span><span class="font-mono">{{ $order->pengiriman->no_resi ?? '-' }}</span></div>
                    <div class="flex justify-between"><span class="text-text-muted">Status</span><span>{{ ucfirst($order->pengiriman->status_pengiriman) }}</span></div>
                </div>
            </div>
            @endif
        </div>
    </div>

    {{-- Order Items --}}
    <div class="glass-card rounded-2xl overflow-hidden">
        <div class="px-6 py-4 border-b border-admin-border">
            <h3 class="font-semibold flex items-center gap-2">
                <span class="material-symbols-outlined text-accent-emerald">receipt_long</span> Item Pesanan
            </h3>
        </div>
        <table class="w-full text-sm">
            <thead>
                <tr class="text-text-muted text-xs uppercase tracking-wider bg-admin-bg/50">
                    <th class="text-left px-6 py-3">Produk</th>
                    <th class="text-left px-6 py-3">Varian</th>
                    <th class="text-left px-6 py-3">Jumlah</th>
                    <th class="text-left px-6 py-3">Harga Satuan</th>
                    <th class="text-left px-6 py-3">Subtotal</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-admin-border/50">
                @foreach($order->items as $item)
                <tr class="hover:bg-admin-card-hover/50 transition-colors">
                    <td class="px-6 py-4">{{ $item->product->nama_produk ?? ($item->customRequest ? 'Custom: '.$item->customRequest->keterangan : '-') }}</td>
                    <td class="px-6 py-4 text-text-muted">{{ $item->variant->size ?? '-' }}</td>
                    <td class="px-6 py-4">{{ $item->jumlah }}</td>
                    <td class="px-6 py-4">Rp {{ number_format($item->harga_satuan, 0, ',', '.') }}</td>
                    <td class="px-6 py-4 font-medium text-accent-gold">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr class="border-t border-admin-border bg-admin-bg/30">
                    <td colspan="4" class="px-6 py-4 text-right font-semibold">Total:</td>
                    <td class="px-6 py-4 font-bold text-lg text-accent-gold">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
@endsection
