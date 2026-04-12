@extends('admin.layouts.app')
@section('title', 'Order Items')
@section('subtitle', 'Detail item dari setiap pesanan')

@section('content')
<div class="space-y-6">
    <div class="glass-card rounded-2xl p-6">
        <form method="GET" class="flex flex-wrap gap-4 items-end">
            <div class="w-48">
                <label class="text-xs text-text-muted mb-1 block">Filter by Order ID</label>
                <input type="number" name="order_id" value="{{ request('order_id') }}" placeholder="Order ID..."
                    class="w-full bg-admin-bg border border-admin-border rounded-xl px-4 py-2.5 text-sm text-text-primary focus:border-accent-emerald outline-none">
            </div>
            <button class="px-6 py-2.5 bg-accent-emerald/10 text-accent-emerald rounded-xl text-sm font-medium hover:bg-accent-emerald/20 transition-colors">
                <span class="material-symbols-outlined text-lg align-middle mr-1">filter_list</span> Filter
            </button>
            @if(request('order_id'))
                <a href="{{ route('admin.order-items.index') }}" class="px-4 py-2.5 text-text-muted text-sm hover:text-text-primary transition-colors">Reset</a>
            @endif
        </form>
    </div>

    <div class="glass-card rounded-2xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-text-muted text-xs uppercase tracking-wider bg-admin-bg/50">
                        <th class="text-left px-6 py-4">ID</th>
                        <th class="text-left px-6 py-4">Order</th>
                        <th class="text-left px-6 py-4">Produk</th>
                        <th class="text-left px-6 py-4">Varian</th>
                        <th class="text-left px-6 py-4">Jumlah</th>
                        <th class="text-left px-6 py-4">Harga Satuan</th>
                        <th class="text-left px-6 py-4">Subtotal</th>
                        <th class="text-left px-6 py-4">Tipe</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-admin-border/50">
                    @forelse($orderItems as $item)
                    <tr class="hover:bg-admin-card-hover/50 transition-colors">
                        <td class="px-6 py-4 font-mono text-text-muted">#{{ $item->id }}</td>
                        <td class="px-6 py-4"><a href="{{ route('admin.orders.show', $item->order_id) }}" class="text-accent-emerald hover:underline">Order #{{ $item->order_id }}</a></td>
                        <td class="px-6 py-4 font-medium">{{ $item->product->nama_produk ?? '-' }}</td>
                        <td class="px-6 py-4 text-text-muted">{{ $item->variant->size ?? '-' }}</td>
                        <td class="px-6 py-4">{{ $item->jumlah }}</td>
                        <td class="px-6 py-4">Rp {{ number_format($item->harga_satuan, 0, ',', '.') }}</td>
                        <td class="px-6 py-4 font-medium text-accent-gold">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                        <td class="px-6 py-4">
                            @if($item->custom_request_id)
                                <span class="px-2 py-1 rounded-full text-xs bg-purple-500/10 text-purple-400">Custom</span>
                            @else
                                <span class="px-2 py-1 rounded-full text-xs bg-accent-emerald/10 text-accent-emerald">Produk</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="8" class="text-center py-12 text-text-muted">
                        <span class="material-symbols-outlined text-4xl block mb-2">receipt_long</span>Belum ada order items
                    </td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($orderItems->hasPages())
        <div class="px-6 py-4 border-t border-admin-border">{{ $orderItems->withQueryString()->links('admin.components.pagination') }}</div>
        @endif
    </div>
</div>
@endsection
