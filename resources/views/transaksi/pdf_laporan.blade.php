<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Penjualan Terlaris</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 8px;
            border: 1px solid #ddd;
            text-align: center;
        }
        th {
            background-color: #f2f2f2;
        }
        .header {
            font-size: 18px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>

    <div class="header">
        <h2>Detail Penjualan Terlaris - {{ $bulan }} {{ $tahun }}</h2>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Produk</th>
                <th>Jumlah Terjual</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($dataProdukTerjual as $detail)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $detail->produk->nama_produk }}</td>
                    <td>{{ $detail->total_jual }}</td>
                    <td>Rp. {{ number_format($detail->total_harga, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3"><strong>Grand Total</strong></td>
                <td><strong>Rp. {{ number_format($totalSemuaTransaksi, 0, ',', '.') }}</strong></td>
            </tr>
        </tfoot>
    </table>

</body>
</html>
