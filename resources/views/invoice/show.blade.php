<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice {{ $order->invoice->invoice_number }} - Toko Bunga Mbah Bibit</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Material Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8f9fa;
            color: #333;
        }
        .invoice-container {
            max-width: 900px;
            margin: 40px auto;
            background: #fff;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.05);
        }
        .invoice-header {
            border-bottom: 2px solid #eee;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .logo-img {
            max-height: 80px;
        }
        .invoice-title {
            font-size: 32px;
            font-weight: 700;
            color: #2c3e50;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .text-muted-custom {
            color: #6c757d;
            font-size: 14px;
        }
        .section-title {
            font-size: 16px;
            font-weight: 600;
            text-transform: uppercase;
            color: #95a5a6;
            margin-bottom: 10px;
            letter-spacing: 0.5px;
        }
        .table-invoice th {
            background-color: #f8f9fa;
            text-transform: uppercase;
            font-size: 13px;
            color: #6c757d;
            padding: 12px 15px;
            border-bottom: none;
        }
        .table-invoice td {
            padding: 15px;
            vertical-align: middle;
            border-bottom: 1px solid #eee;
        }
        .summary-row {
            font-size: 15px;
        }
        .summary-total {
            font-size: 20px;
            font-weight: 700;
            color: #2c3e50;
        }
        .status-badge {
            padding: 6px 12px;
            border-radius: 50px;
            font-weight: 600;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .badge-paid {
            background-color: #e8f8f5;
            color: #1abc9c;
            border: 1px solid #a3e4d7;
        }
        .badge-pending {
            background-color: #fef9e7;
            color: #f1c40f;
            border: 1px solid #f9e79f;
        }
        @media print {
            body {
                background-color: #fff;
            }
            .invoice-container {
                box-shadow: none;
                margin: 0;
                padding: 0;
                width: 100%;
                max-width: 100%;
            }
            .no-print {
                display: none !important;
            }
        }
    </style>
</head>
<body>

<div class="container mb-5">
    
    <!-- Action Buttons (Hidden on Print) -->
    <div class="row mt-4 mb-3 no-print">
        <div class="col-12 d-flex justify-content-between align-items-center max-w-900 mx-auto" style="max-width: 900px;">
            <a href="{{ route('profile.index') }}" class="btn btn-outline-secondary d-flex align-items-center gap-2">
                <span class="material-symbols-outlined fs-6">arrow_back</span>
                Kembali ke Dashboard
            </a>
            <div class="d-flex gap-2">
                <button onclick="window.print()" class="btn btn-primary d-flex align-items-center gap-2">
                    <span class="material-symbols-outlined fs-6">print</span>
                    Cetak
                </button>
                <a href="{{ route('invoice.download', $order->id) }}" class="btn btn-success d-flex align-items-center gap-2">
                    <span class="material-symbols-outlined fs-6">download</span>
                    Download PDF
                </a>
            </div>
        </div>
    </div>

    <!-- Invoice Card -->
    <div class="invoice-container">
        
        <!-- Header -->
        <div class="row invoice-header align-items-center">
            <div class="col-sm-6">
                <img src="{{ asset('images/logo.png') }}" alt="Toko Bunga Mbah Bibit" class="logo-img mb-2">
                <h4 class="mb-0 fw-bold" style="color: #4a4a4a;">Toko Bunga Mbah Bibit</h4>
                <div class="text-muted-custom mt-1">Madiun, Jawa Timur<br>Email: toko@mbahbibit.com</div>
            </div>
            <div class="col-sm-6 text-sm-end mt-4 mt-sm-0">
                <div class="invoice-title">INVOICE</div>
                <div class="fw-bold fs-5 mt-2">{{ $order->invoice->invoice_number }}</div>
                <div class="text-muted-custom mt-1">Order ID: #ORD-{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</div>
                <div class="text-muted-custom">Tanggal: {{ $order->created_at->format('d M Y') }}</div>
            </div>
        </div>

        <!-- Info Grid -->
        <div class="row mb-5">
            <div class="col-sm-6">
                <div class="section-title">Diterbitkan Kepada</div>
                <div class="fw-bold fs-5 mb-1">{{ $order->customer_name }}</div>
                <div class="text-muted-custom mb-1">{{ $order->customer_email }}</div>
                <div class="text-muted-custom mb-1">{{ $order->customer_phone }}</div>
                <div class="text-muted-custom mt-2 lh-base">
                    <strong>Alamat Pengiriman:</strong><br>
                    @if($order->pengiriman)
                        {{ $order->pengiriman->nama_penerima }}<br>
                        {{ $order->pengiriman->alamat_pengiriman }}
                    @else
                        {{ $order->alamat_pengiriman }}
                    @endif
                </div>
            </div>
            <div class="col-sm-6 text-sm-end mt-4 mt-sm-0">
                <div class="section-title">Pembayaran</div>
                <div class="mb-3">
                    <span class="status-badge {{ $order->status === 'paid' ? 'badge-paid' : 'badge-pending' }}">
                        {{ $order->status === 'paid' ? 'Lunas' : ucfirst($order->status) }}
                    </span>
                </div>
                <div class="text-muted-custom mb-1">
                    Metode: <strong>{{ ucfirst($order->metode_pembayaran) }}</strong>
                </div>
                <div class="text-muted-custom">
                    Tgl Bayar: 
                    @if($order->pembayaran && $order->pembayaran->tanggal_bayar)
                        {{ $order->pembayaran->tanggal_bayar->format('d M Y H:i') }}
                    @else
                        -
                    @endif
                </div>
            </div>
        </div>

        <!-- Items Table -->
        <div class="table-responsive mb-4">
            <table class="table table-invoice mb-0">
                <thead>
                    <tr>
                        <th width="45%">Nama Produk</th>
                        <th class="text-center" width="15%">Jumlah</th>
                        <th class="text-end" width="20%">Harga Satuan</th>
                        <th class="text-end" width="20%">Subtotal</th>
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
                            <td>
                                <div class="fw-bold text-dark">{{ $item->product->nama_produk ?? 'Custom Request' }}</div>
                            </td>
                            <td class="text-center">{{ $item->jumlah }}</td>
                            <td class="text-end">Rp {{ number_format($item->harga_satuan, 0, ',', '.') }}</td>
                            <td class="text-end fw-bold">Rp {{ number_format($itemSubtotal, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Summary -->
        <div class="row justify-content-end">
            <div class="col-sm-6 col-md-5">
                <div class="d-flex justify-content-between summary-row mb-2">
                    <span class="text-muted">Subtotal Produk</span>
                    <span class="fw-bold">Rp {{ number_format($subtotalProducts, 0, ',', '.') }}</span>
                </div>
                @php
                    $shippingCost = 0; // Update this if shipping cost is implemented in db
                @endphp
                <div class="d-flex justify-content-between summary-row mb-3">
                    <span class="text-muted">Ongkos Kirim</span>
                    <span class="fw-bold">Rp {{ number_format($shippingCost, 0, ',', '.') }}</span>
                </div>
                <div class="d-flex justify-content-between align-items-center summary-total pt-3 border-top">
                    <span>Grand Total</span>
                    <span class="text-primary">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="row mt-5 pt-4 border-top text-center">
            <div class="col-12">
                <p class="mb-1 text-muted-custom fst-italic">Terima kasih telah berbelanja.</p>
                <p class="mb-0 text-muted-custom" style="font-size: 12px;">Invoice ini dicetak otomatis oleh sistem dan sah sebagai bukti pembayaran.</p>
            </div>
        </div>

    </div>
</div>

<!-- Bootstrap 5 JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.css"></script>
</body>
</html>
