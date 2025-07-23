<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Transaksi - Pet Hotel</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #4F46E5;
            padding-bottom: 20px;
        }
        .header h1 {
            color: #4F46E5;
            margin: 0;
            font-size: 24px;
        }
        .header p {
            margin: 5px 0;
            color: #666;
        }
        .filters {
            margin-bottom: 20px;
            padding: 10px;
            background-color: #f8f9fa;
            border-radius: 5px;
        }
        .filters h3 {
            margin: 0 0 10px 0;
            color: #4F46E5;
            font-size: 14px;
        }
        .filter-item {
            display: inline-block;
            margin-right: 20px;
            margin-bottom: 5px;
        }
        .filter-label {
            font-weight: bold;
            color: #666;
        }
        .stats {
            margin-bottom: 20px;
        }
        .stats h3 {
            color: #4F46E5;
            font-size: 14px;
            margin-bottom: 10px;
        }
        .stat-grid {
            display: table;
            width: 100%;
            border-collapse: collapse;
        }
        .stat-item {
            display: table-cell;
            width: 25%;
            padding: 10px;
            text-align: center;
            border: 1px solid #ddd;
            background-color: #f8f9fa;
        }
        .stat-value {
            font-size: 16px;
            font-weight: bold;
            color: #4F46E5;
        }
        .stat-label {
            font-size: 10px;
            color: #666;
            margin-top: 5px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th {
            background-color: #4F46E5;
            color: white;
            padding: 8px;
            text-align: left;
            font-size: 10px;
        }
        td {
            padding: 6px 8px;
            border-bottom: 1px solid #ddd;
            font-size: 9px;
        }
        tr:nth-child(even) {
            background-color: #f8f9fa;
        }
        .total-row {
            background-color: #e8f5e8 !important;
            font-weight: bold;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
        .page-break {
            page-break-before: always;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>PET HOTEL</h1>
        <p>Laporan Transaksi</p>
        <p>Dicetak pada: {{ now()->format('d/m/Y H:i:s') }}</p>
    </div>

    <div class="filters">
        <h3>Filter Laporan:</h3>
        <div class="filter-item">
            <span class="filter-label">Periode:</span> 
            @switch($periode)
                @case('today') Hari Ini @break
                @case('week') Minggu Ini @break
                @case('month') Bulan Ini @break
                @case('quarter') Kuartal Ini @break
                @case('year') Tahun Ini @break
            @endswitch
        </div>
        @if($jenisLayanan)
        <div class="filter-item">
            <span class="filter-label">Layanan:</span> {{ ucfirst($jenisLayanan) }}
        </div>
        @endif
        @if($statusPembayaran)
        <div class="filter-item">
            <span class="filter-label">Status Pembayaran:</span> {{ ucfirst(str_replace('_', ' ', $statusPembayaran)) }}
        </div>
        @endif
    </div>

    <div class="stats">
        <h3>Ringkasan Statistik:</h3>
        <div class="stat-grid">
            <div class="stat-item">
                <div class="stat-value">{{ $totalTransactions }}</div>
                <div class="stat-label">Total Transaksi</div>
            </div>
            <div class="stat-item">
                <div class="stat-value">Rp {{ number_format($totalIncome, 0, ',', '.') }}</div>
                <div class="stat-label">Total Pendapatan</div>
            </div>
            <div class="stat-item">
                <div class="stat-value">Rp {{ number_format($penitipanIncome, 0, ',', '.') }}</div>
                <div class="stat-label">Pendapatan Penitipan</div>
            </div>
            <div class="stat-item">
                <div class="stat-value">Rp {{ number_format($groomingIncome, 0, ',', '.') }}</div>
                <div class="stat-label">Pendapatan Grooming</div>
            </div>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Tanggal</th>
                <th>Pelanggan</th>
                <th>Hewan</th>
                <th>Layanan</th>
                <th>Total Harga</th>
                <th>Status Pembayaran</th>
                <th>Jumlah Dibayar</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transaksis as $transaksi)
            <tr>
                <td>{{ $transaksi->id }}</td>
                <td>{{ $transaksi->created_at->format('d/m/Y') }}</td>
                <td>{{ $transaksi->pelanggan->nama ?? '-' }}</td>
                <td>{{ $transaksi->hewan->nama ?? '-' }}</td>
                <td>
                    @php
                        $layanan = is_string($transaksi->jenis_layanan) ? json_decode($transaksi->jenis_layanan, true) : $transaksi->jenis_layanan;
                        $layananText = is_array($layanan) ? implode(', ', $layanan) : $transaksi->jenis_layanan;
                    @endphp
                    {{ $layananText }}
                </td>
                <td>Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</td>
                <td>{{ ucfirst(str_replace('_', ' ', $transaksi->status_pembayaran ?? '-')) }}</td>
                <td>Rp {{ number_format($transaksi->jumlah_dibayar ?? 0, 0, ',', '.') }}</td>
            </tr>
            @endforeach
            <tr class="total-row">
                <td colspan="5"><strong>TOTAL</strong></td>
                <td><strong>Rp {{ number_format($totalIncome, 0, ',', '.') }}</strong></td>
                <td colspan="2"></td>
            </tr>
        </tbody>
    </table>

    <div class="footer">
        <p>Laporan ini dibuat secara otomatis oleh sistem Pet Hotel</p>
        <p>© {{ date('Y') }} Pet Hotel. Semua hak dilindungi.</p>
    </div>
</body>
</html> 