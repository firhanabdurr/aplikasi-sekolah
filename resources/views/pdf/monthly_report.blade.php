<!DOCTYPE html>
<html>
<head>
    <title>{{ $title }}</title>
    <style>
        body { font-family: 'Helvetica', sans-serif; font-size: 12px; }
        .container { width: 100%; margin: 0 auto; }
        .header { text-align: center; margin-bottom: 20px; }
        .header h1 { margin: 0; font-size: 24px; }
        .header h2 { margin: 0; font-size: 18px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .total-row td { font-weight: bold; }
        .summary { width: 50%; float: right; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Laporan Keuangan</h1>
            <h2>Bulan: {{ $namaBulan }} {{ $tahun }}</h2>
        </div>

        <h3>Pemasukan</h3>
        <table>
            <thead>
                <tr>
                    <th>Sumber Pemasukan</th>
                    <th>Jumlah</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Pembayaran SPP</td>
                    <td>Rp {{ number_format($pemasukan_spp, 2, ',', '.') }}</td>
                </tr>
                <tr>
                    <td>Setoran Tabungan</td>
                    <td>Rp {{ number_format($pemasukan_tabungan, 2, ',', '.') }}</td>
                </tr>
                <tr class="total-row">
                    <td>Total Pemasukan</td>
                    <td>Rp {{ number_format($total_pemasukan, 2, ',', '.') }}</td>
                </tr>
            </tbody>
        </table>

        <h3>Pengeluaran</h3>
        <table>
            <thead>
                <tr>
                    <th>Jenis Pengeluaran</th>
                    <th>Jumlah</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Penarikan Tabungan</td>
                    <td>Rp {{ number_format($pengeluaran_tabungan, 2, ',', '.') }}</td>
                </tr>
                <tr class="total-row">
                    <td>Total Pengeluaran</td>
                    <td>Rp {{ number_format($total_pengeluaran, 2, ',', '.') }}</td>
                </tr>
            </tbody>
        </table>

        <h3>Ringkasan</h3>
        <table class="summary">
             <tbody>
                <tr class="total-row">
                    <td>Total Pemasukan</td>
                    <td>Rp {{ number_format($total_pemasukan, 2, ',', '.') }}</td>
                </tr>
                <tr class="total-row">
                    <td>Total Pengeluaran</td>
                    <td>Rp {{ number_format($total_pengeluaran, 2, ',', '.') }}</td>
                </tr>
                <tr class="total-row">
                    <td>Surplus / Defisit</td>
                    <td>Rp {{ number_format($total_pemasukan - $total_pengeluaran, 2, ',', '.') }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</body>
</html>