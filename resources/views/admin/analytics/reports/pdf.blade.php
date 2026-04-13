<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Penjualan Mbah Bibit</title>
    <style>
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            color: #2c2e2a;
            line-height: 1.6;
            margin: 0;
            padding: 0;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #a5a68f;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .logo {
            font-size: 24px;
            font-weight: bold;
            color: #a5a68f;
            text-transform: uppercase;
            letter-spacing: 2px;
        }
        .report-title {
            font-size: 18px;
            margin-top: 5px;
            color: #4a4e46;
        }
        .date {
            font-size: 12px;
            color: #7a7f75;
        }
        .summary-grid {
            width: 100%;
            margin-bottom: 40px;
        }
        .summary-box {
            background: #fafae3;
            border: 1px solid #d9d9c3;
            padding: 15px;
            text-align: center;
        }
        .summary-label {
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #7a7f75;
            margin-bottom: 5px;
        }
        .summary-value {
            font-size: 20px;
            font-weight: bold;
            color: #a5a68f;
        }
        h3 {
            font-size: 16px;
            border-left: 4px solid #a5a68f;
            padding-left: 10px;
            margin-bottom: 15px;
            color: #2c2e2a;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        th {
            background: #a5a68f;
            color: #fafae3;
            text-align: left;
            padding: 10px;
            font-size: 12px;
            text-transform: uppercase;
        }
        td {
            padding: 10px;
            border-bottom: 1px solid #e5e5d5;
            font-size: 12px;
        }
        .footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            text-align: center;
            font-size: 10px;
            color: #7a7f75;
            border-top: 1px solid #e5e5d5;
            padding-top: 10px;
        }
        .text-right { text-align: right; }
        .font-bold { font-weight: bold; }
    </style>
</head>
<body>
    <div class="header">
        <div class="logo">Mbah Bibit Botanical Archiv</div>
        <div class="report-title">Laporan Penjualan & Statistik Performa</div>
        <div class="date">Dicetak pada: {{ $reportDate }}</div>
    </div>

    <table class="summary-grid">
        <tr>
            <td class="summary-box" style="width: 33%;">
                <div class="summary-label">Total Revenue</div>
                <div class="summary-value">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</div>
            </td>
            <td class="summary-box" style="width: 33%;">
                <div class="summary-label">Total Pesanan</div>
                <div class="summary-value">{{ number_format($totalOrders) }}</div>
            </td>
            <td class="summary-box" style="width: 33%;">
                <div class="summary-label">Nilai Rata-rata</div>
                <div class="summary-value">Rp {{ number_format($avgOrderValue, 0, ',', '.') }}</div>
            </td>
        </tr>
    </table>

    <h3>Produk Terlaris (Top 10)</h3>
    <table>
        <thead>
            <tr>
                <th style="width: 10%;">Rank</th>
                <th style="width: 50%;">Nama Produk</th>
                <th style="width: 20%;" class="text-right">Unit Terjual</th>
                <th style="width: 20%;" class="text-right">Revenue</th>
            </tr>
        </thead>
        <tbody>
            @foreach($topProducts as $i => $tp)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td class="font-bold">{{ $tp->nama_produk }}</td>
                <td class="text-right">{{ number_format($tp->total_sold) }} unit</td>
                <td class="text-right">Rp {{ number_format($tp->total_revenue, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <h3>Distribusi Status Pesanan</h3>
    <table>
        <thead>
            <tr>
                <th>Status Pesanan</th>
                <th class="text-right">Jumlah Order</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orderByStatus as $os)
            <tr>
                <td style="text-transform: capitalize;">{{ $os->status }}</td>
                <td class="text-right">{{ number_format($os->count) }} order</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        Mbah Bibit Botanical Archiv — Laporan Resmi Generasi Sistem Otomatis
    </div>
</body>
</html>
