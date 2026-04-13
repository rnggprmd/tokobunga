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
                
                {{-- Ucapan Display Removed --}}
            </div>
        </div>

        {{-- Payment & Shipping --}}
        <div class="space-y-6">
            {{-- Payment Section --}}
            <div class="glass-card rounded-2xl p-6 space-y-3">
                <div class="flex justify-between items-center mb-1">
                    <h3 class="font-semibold flex items-center gap-2 text-accent-gold text-sm">
                        <span class="material-symbols-outlined">payments</span> Pembayaran
                    </h3>
                    @if(!$order->pembayaran)
                        <button onclick="document.getElementById('payment-modal').classList.remove('hidden')" class="text-[10px] bg-accent-gold/10 text-accent-gold px-2 py-1 rounded-lg hover:bg-accent-gold/20 transition-colors uppercase font-bold tracking-wider">Record Payment</button>
                    @endif
                </div>

                @if($order->pembayaran)
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between"><span class="text-text-muted">Metode</span><span>{{ $order->pembayaran->metode_pembayaran }}</span></div>
                    <div class="flex justify-between"><span class="text-text-muted">Jumlah</span><span>Rp {{ number_format($order->pembayaran->jumlah_bayar, 0, ',', '.') }}</span></div>
                    <div class="flex justify-between"><span class="text-text-muted">Status</span>
                        <span class="{{ $order->pembayaran->status_pembayaran == 'paid' ? 'text-emerald-400' : 'text-yellow-400' }}">{{ ucfirst($order->pembayaran->status_pembayaran) }}</span>
                    </div>
                </div>
                @else
                <p class="text-xs text-text-muted italic">Belum ada data pembayaran.</p>
                @endif
            </div>

            {{-- Shipping Section --}}
            <div class="glass-card rounded-2xl p-6 space-y-3">
                <div class="flex justify-between items-center mb-1">
                    <h3 class="font-semibold flex items-center gap-2 text-blue-400 text-sm">
                        <span class="material-symbols-outlined">local_shipping</span> Pengiriman
                    </h3>
                    @if(!$order->pengiriman)
                        <button onclick="document.getElementById('shipping-modal').classList.remove('hidden')" class="text-[10px] bg-blue-500/10 text-blue-400 px-2 py-1 rounded-lg hover:bg-blue-500/20 transition-colors uppercase font-bold tracking-wider">Record Shipping</button>
                    @endif
                </div>

                @if($order->pengiriman)
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between"><span class="text-text-muted">Kurir</span><span>{{ $order->pengiriman->kurir ?? '-' }}</span></div>
                    <div class="flex justify-between"><span class="text-text-muted">Resi</span><span class="font-mono">{{ $order->pengiriman->no_resi ?? '-' }}</span></div>
                    <div class="flex justify-between"><span class="text-text-muted">Status</span><span>{{ ucfirst($order->pengiriman->status_pengiriman) }}</span></div>
                    @if($order->pengiriman->no_hp_kurir)
                    <div class="flex justify-between"><span class="text-text-muted">HP Kurir</span><span class="text-accent-emerald font-medium">{{ $order->pengiriman->no_hp_kurir }}</span></div>
                    @endif
                </div>
                @else
                <p class="text-xs text-text-muted italic">Belum ada data pengiriman.</p>
                @endif
            </div>
        </div>
    </div>

    {{-- Payment Modal --}}
    <div id="payment-modal" class="hidden fixed inset-0 bg-black/60 z-50 flex items-center justify-center p-4" onclick="if(event.target===this)this.classList.add('hidden')">
        <div class="bg-admin-card border border-admin-border rounded-2xl p-6 w-full max-w-md shadow-2xl">
            <h4 class="font-bold text-lg mb-1 flex items-center gap-2"><span class="material-symbols-outlined text-accent-gold">payments</span> Record Payment</h4>
            <p class="text-xs text-text-muted mb-6">Input detail pembayaran untuk order #{{ $order->id }}</p>
            
            <form method="POST" action="{{ route('admin.orders.payment.store', $order) }}" enctype="multipart/form-data">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label class="text-xs text-text-muted mb-1 block">Metode Pembayaran</label>
                        <select name="metode_pembayaran" class="w-full bg-admin-bg border border-admin-border rounded-xl px-4 py-2 text-sm text-text-primary">
                            <option value="Cash">Cash / Offline</option>
                            <option value="Transfer">Bank Transfer</option>
                            <option value="E-Wallet">E-Wallet</option>
                        </select>
                    </div>
                    <div>
                        <label class="text-xs text-text-muted mb-1 block">Jumlah Bayar (Rp)</label>
                        <input type="number" name="jumlah_bayar" value="{{ (int)$order->total_harga }}" class="w-full bg-admin-bg border border-admin-border rounded-xl px-4 py-2 text-sm">
                    </div>
                    <div>
                        <label class="text-xs text-text-muted mb-1 block">Status Pembayaran</label>
                        <select name="status_pembayaran" class="w-full bg-admin-bg border border-admin-border rounded-xl px-4 py-2 text-sm">
                            <option value="paid">Paid (Lunas)</option>
                            <option value="pending">Pending</option>
                            <option value="failed">Failed</option>
                        </select>
                    </div>
                </div>
                <div class="flex gap-2 mt-8">
                    <button type="submit" class="flex-1 bg-accent-gold text-white py-2.5 rounded-xl text-sm font-bold shadow-lg shadow-accent-gold/20">Simpan Payment</button>
                    <button type="button" onclick="document.getElementById('payment-modal').classList.add('hidden')" class="flex-1 bg-admin-bg border border-admin-border py-2.5 rounded-xl text-sm font-semibold">Tutup</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Shipping Modal --}}
    <div id="shipping-modal" class="hidden fixed inset-0 bg-black/60 z-50 flex items-center justify-center p-4" onclick="if(event.target===this)this.classList.add('hidden')">
        <div class="bg-admin-card border border-admin-border rounded-2xl p-6 w-full max-w-md shadow-2xl">
            <h4 class="font-bold text-lg mb-1 flex items-center gap-2"><span class="material-symbols-outlined text-blue-400">local_shipping</span> Record Shipping</h4>
            <p class="text-xs text-text-muted mb-6">Input detail pengiriman untuk order #{{ $order->id }}</p>
            
            <form method="POST" action="{{ route('admin.orders.shipping.store', $order) }}">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label class="text-xs text-text-muted mb-1 block">Kurir / Ekspedisi</label>
                        <input type="text" name="kurir" placeholder="Contoh: JNE, J&T, Kurir Toko" class="w-full bg-admin-bg border border-admin-border rounded-xl px-4 py-2 text-sm" required>
                    </div>
                    <div>
                        <label class="text-xs text-text-muted mb-1 block">No Resi (Opsional)</label>
                        <input type="text" name="no_resi" class="w-full bg-admin-bg border border-admin-border rounded-xl px-4 py-2 text-sm font-mono">
                    </div>
                    <div>
                        <label class="text-xs text-text-muted mb-1 block">No. HP Kurir (Opsional)</label>
                        <input type="text" name="no_hp_kurir" placeholder="Bisa nomor WA kurir" class="w-full bg-admin-bg border border-admin-border rounded-xl px-4 py-2 text-sm">
                    </div>
                    <div>
                        <label class="text-xs text-text-muted mb-1 block">Status Pengiriman</label>
                        <select name="status_pengiriman" class="w-full bg-admin-bg border border-admin-border rounded-xl px-4 py-2 text-sm">
                            <option value="pending">Pending</option>
                            <option value="dikirim">Dikirim (In Transit)</option>
                            <option value="sampai">Sampai (Delivered)</option>
                        </select>
                    </div>
                </div>
                <div class="flex gap-2 mt-8">
                    <button type="submit" class="flex-1 bg-blue-500 text-white py-2.5 rounded-xl text-sm font-bold shadow-lg shadow-blue-500/20">Simpan Shipping</button>
                    <button type="button" onclick="document.getElementById('shipping-modal').classList.add('hidden')" class="flex-1 bg-admin-bg border border-admin-border py-2.5 rounded-xl text-sm font-semibold">Tutup</button>
                </div>
            </form>
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
                    <th class="text-left px-6 py-3">Jumlah</th>
                    <th class="text-left px-6 py-3">Harga Satuan</th>
                    <th class="text-left px-6 py-3">Subtotal</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-admin-border/50">
                @foreach($order->items as $item)
                <tr class="hover:bg-admin-card-hover/50 transition-colors">
                    <td class="px-6 py-4">{{ $item->product->nama_produk ?? ($item->customRequest ? 'Custom: '.$item->customRequest->keterangan : '-') }}</td>
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
