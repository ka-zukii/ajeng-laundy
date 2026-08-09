<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Invoice {{ $transaksi->kode_transaksi }}</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            font-size: 14px;
            color: #333;
        }

        .header {
            width: 100%;
            margin-bottom: 30px;
        }

        .header td {
            vertical-align: top;
        }

        .title {
            font-size: 28px;
            font-weight: bold;
            color: #ff7797;
            /* Warna ajeng-pink */
            margin-bottom: 5px;
        }

        .info-table {
            width: 100%;
            margin-bottom: 30px;
            border-collapse: collapse;
        }

        .info-table td {
            padding: 4px 0;
        }

        .details-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }

        .details-table th {
            background: #ffe6ee;
            padding: 12px;
            border-bottom: 2px solid #ff7797;
            text-align: left;
            font-size: 12px;
            text-transform: uppercase;
            color: #333;
        }

        .details-table td {
            padding: 12px;
            border-bottom: 1px solid #eee;
        }

        .text-right {
            text-align: right !important;
        }

        .summary-box {
            float: right;
            width: 300px;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }

        .summary-row {
            width: 100%;
            display: table;
            padding: 3px 0;
        }

        .summary-label {
            display: table-cell;
            text-align: left;
        }

        .summary-value {
            display: table-cell;
            text-align: right;
            font-weight: bold;
        }

        .grand-total {
            font-size: 18px;
            color: #ff7797;
            font-weight: bold;
            border-top: 2px solid #333;
            padding-top: 5px;
            margin-top: 5px;
        }
    </style>
</head>

<body>

    @php
        $detail = $transaksi->transaksiDetail;
    @endphp

    <table class="header">
        <tr>
            <td>
                <div class="title">AJENG LAUNDRY</div>
                <p style="margin: 0; color: #666;">
                    Pusat Layanan Kebersihan Pakaian<br>
                    Cepat, Wangi, & Rapih
                </p>
            </td>
            <td class="text-right">
                <h2 style="margin:0; color: #333;">INVOICE</h2>
                <p style="margin: 5px 0 0 0; font-weight: bold;">#{{ $transaksi->kode_transaksi }}</p>
                <p style="margin: 0; color: #666;">
                    {{ \Carbon\Carbon::parse($transaksi->tanggal_masuk)->format('d F Y') }}</p>
            </td>
        </tr>
    </table>

    <table class="info-table">
        <tr>
            <td width="20%"><strong>Pelanggan</strong></td>
            <td width="30%">: {{ $transaksi->pelanggan->nama ?? 'Umum' }}</td>
            <td width="20%"><strong>Laundry</strong></td>
            <td width="30%">: {{ $transaksi->status_laundry->label() ?? '-' }}</td>
        </tr>
        <tr>
            <td><strong>Metode Bayar</strong></td>
            <td>: QRIS</td>
            <td><strong>Pembayaran</strong></td>
            <td>: {{ $transaksi->pembayaran ? $transaksi->pembayaran->status_pembayaran->label() : 'Menunggu' }}</td>
        </tr>
    </table>

    <table class="details-table">
        <thead>
            <tr>
                <th>Layanan</th>
                <th class="text-right">Total Item</th>
                <th class="text-right">Harga Dasar</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $detail->layanan->nama_layanan ?? 'Regular ( Daily Kiloan )' }}</td>
                <td class="text-right">{{ $detail->berat ?? 0 }} Kg</td>
                <td class="text-right">Rp {{ number_format($transaksi->total_biaya ?? 0, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

    <div class="summary-box">
        <div class="summary-row">
            <div class="summary-label">Subtotal</div>
            <div class="summary-value">Rp {{ number_format($transaksi->total_biaya ?? 0, 0, ',', '.') }}</div>
        </div>
        <div class="summary-row">
            <div class="summary-label">Biaya Admin</div>
            <div class="summary-value">Rp 500</div>
        </div>
        <div class="summary-row">
            <div class="summary-label">Biaya Layanan</div>
            <div class="summary-value">Rp 1.000</div>
        </div>
        <div class="summary-row grand-total">
            <div class="summary-label">TOTAL AKHIR</div>
            <div class="summary-value">Rp {{ number_format(($transaksi->total_biaya ?? 0) + 1500, 0, ',', '.') }}</div>
        </div>
    </div>

    <div style="clear: both; margin-top: 80px; text-align: center; color: #888; font-size: 12px;">
        <p>Terima kasih telah mempercayakan pakaian Anda kepada Ajeng Laundry.</p>
    </div>

</body>

</html>
