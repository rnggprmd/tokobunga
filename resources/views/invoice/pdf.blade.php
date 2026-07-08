<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Invoice {{ $order->invoice->invoice_number ?? 'Draft' }}</title>
    <style>
        body {
            font-family: 'Helvetica Neue', 'Helvetica', Arial, sans-serif;
            color: #333;
            font-size: 14px;
            line-height: 1.4;
            margin: 0;
            padding: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        .header {
            margin-bottom: 30px;
            border-bottom: 2px solid #eee;
            padding-bottom: 20px;
        }
        .header td {
            vertical-align: top;
        }
        .title {
            font-size: 28px;
            font-weight: bold;
            color: #2c3e50;
            text-transform: uppercase;
        }
        .invoice-details {
            text-align: right;
        }
        .invoice-details span {
            display: block;
            color: #666;
            margin-top: 3px;
        }
        .section-title {
            font-size: 14px;
            font-weight: bold;
            text-transform: uppercase;
            color: #999;
            margin-bottom: 8px;
            border-bottom: 1px solid #eee;
            padding-bottom: 4px;
        }
        .info-table {
            margin-bottom: 30px;
        }
        .info-table td {
            width: 50%;
            vertical-align: top;
        }
        .items-table {
            margin-bottom: 30px;
        }
        .items-table th {
            background-color: #f8f9fa;
            color: #555;
            padding: 10px;
            text-align: left;
            border-bottom: 2px solid #ddd;
            font-size: 12px;
            text-transform: uppercase;
        }
        .items-table td {
            padding: 12px 10px;
            border-bottom: 1px solid #eee;
        }
        .text-right {
            text-align: right !important;
        }
        .text-center {
            text-align: center !important;
        }
        .totals-table {
            width: 40%;
            float: right;
        }
        .totals-table td {
            padding: 8px 10px;
        }
        .totals-table .total-row {
            font-weight: bold;
            font-size: 16px;
            color: #2c3e50;
            border-top: 2px solid #ddd;
        }
        .footer {
            clear: both;
            margin-top: 50px;
            text-align: center;
            color: #777;
            font-size: 12px;
            border-top: 1px solid #eee;
            padding-top: 20px;
            font-style: italic;
        }
        .badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 3px;
            font-size: 11px;
            font-weight: bold;
            text-transform: uppercase;
            color: #fff;
        }
        .badge-paid {
            background-color: #2ecc71;
        }
        .badge-pending {
            background-color: #f1c40f;
        }
    </style>
</head>
<body>

    <table class="header">
        <tr>
            <td width="50%">
                <h2 style="margin: 0; color: #4a4a4a;">Toko Bunga Mbah Bibit</h2>
                <div style="color: #666; margin-top: 8px; font-size: 12px;">
                    Madiun, Jawa Timur<br>
                    Email: toko@mbahbibit.com
                </div>
            </td>
            <td width="50%" class="invoice-details">
                <div class="title">INVOICE</div>
                <div style="font-size: 18px; font-weight: bold; margin-top: 5px;">
                    {{ $order->invoice->invoice_number ?? 'DRAFT' }}
                </div>
                <span>Order ID: #ORD-{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</span>
                <span>Tanggal: {{ $order->created_at->format('d M Y') }}</span>
            </td>
        </tr>
    </table>

    <table class="info-table">
        <tr>
            <td style="padding-right: 20px;">
                <div class="section-title">Diterbitkan Kepada</div>
                <strong style="font-size: 16px;">{{ $order->customer_name }}</strong><br>
                <span style="color: #666; display: block; margin-top: 4px;">{{ $order->customer_email }}</span>
                <span style="color: #666; display: block;">{{ $order->customer_phone }}</span>
                <div style="color: #666; margin-top: 10px; line-height: 1.5;">
                    <strong>Alamat Pengiriman:</strong><br>
                    @if($order->pengiriman)
                        {{ $order->pengiriman->nama_penerima }}<br>
                        {{ $order->pengiriman->alamat_pengiriman }}
                    @else
                        {{ $order->alamat_pengiriman }}
                    @endif
                </div>
            </td>
            <td>
                <div class="section-title">Pembayaran</div>
                <div style="margin-bottom: 10px;">
                    <span class="badge {{ $order->status === 'paid' ? 'badge-paid' : 'badge-pending' }}">
                        {{ $order->status === 'paid' ? 'LUNAS' : strtoupper($order->status) }}
                    </span>
                </div>
                <span style="color: #666; display: block; margin-bottom: 4px;">
                    Metode: <strong>{{ strtoupper($order->metode_pembayaran) }}</strong>
                </span>
                <span style="color: #666; display: block;">
                    Tgl Bayar: 
                    @if($order->pembayaran && $order->pembayaran->tanggal_bayar)
                        {{ $order->pembayaran->tanggal_bayar->format('d M Y H:i') }}
                    @else
                        -
                    @endif
                </span>
            </td>
        </tr>
    </table>

    <table class="items-table">
        <thead>
            <tr>
                <th width="45%">Nama Produk</th>
                <th width="15%" class="text-center">Jumlah</th>
                <th width="20%" class="text-right">Harga Satuan</th>
                <th width="20%" class="text-right">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @php $subtotalProducts = 0; @endphp
            @foreach($order->items as $item)
                @php 
                    $itemSubtotal = $item->subtotal ?: ($item->harga_satuan * $item->jumlah);
                    $subtotalProducts += $itemSubtotal;
                @endphp
                <tr>
                    <td><strong>{{ $item->product->nama_produk ?? 'Custom Request' }}</strong></td>
                    <td class="text-center">{{ $item->jumlah }}</td>
                    <td class="text-right">Rp {{ number_format($item->harga_satuan, 0, ',', '.') }}</td>
                    <td class="text-right"><strong>Rp {{ number_format($itemSubtotal, 0, ',', '.') }}</strong></td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <table class="totals-table">
        <tr>
            <td style="color: #666;">Subtotal Produk</td>
            <td class="text-right">Rp {{ number_format($subtotalProducts, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td style="color: #666;">Ongkos Kirim</td>
            <td class="text-right">Rp 0</td>
        </tr>
        <tr class="total-row">
            <td>Grand Total</td>
            <td class="text-right" style="color: #27ae60;">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</td>
        </tr>
    </table>

    <div class="footer">
        Terima kasih telah berbelanja.<br>
        Invoice ini dicetak otomatis oleh sistem dan sah sebagai bukti pembayaran.
    </div>

</body>
</html>
