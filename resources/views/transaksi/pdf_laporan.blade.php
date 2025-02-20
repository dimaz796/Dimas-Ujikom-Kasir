<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Penjualan Terlaris</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 20px;
        }
        .text-center {
            text-align: center;
        }
        .text-right {
            text-align: right;
        }
        .bold {
            font-weight: bold;
        }
        .title {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .address {
            font-size: 12px;
            text-align: center;
            margin-bottom: 10px;
        }
        .separator {
            border-top: 2px solid black;
            margin: 10px 0;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        .table, .table th, .table td {
            border: 1px solid black;
        }
        .table th, .table td {
            padding: 8px;
            text-align: left;
        }
        .table th {
            background-color: #f3f3f3;
        }
        .table .text-right {
            text-align: right;
        }
        .grand-total {
            background-color: #f3f3f3;
            font-weight: bold;
        }
        .admin-info {
            text-align: right;
            margin-top: 40px;
            float: right;
        }
        .signature {
            margin-top: 50px;
            text-align: right;
            font-weight: bold;
        }
    </style>
</head>
<body>

    <!-- Judul dan Alamat -->
    <h2 class="text-center title">Laporan Penjualan Terlaris</h2>
    <p class="address">
        {{ $alamat }}
    </p>
    <p class="address">
        Telephone {{ $telephone }}
    </p>

    <div class="separator"></div>

    <h2 class="text-center">Detail Penjualan Bulan {{ $bulanNama }}</h2>

    <!-- Tabel Detail Penjualan -->
    <table class="table">
        <thead>
            <tr>
                <th>No</th>
                <th>Produk</th>
                <th>Jumlah Terjual</th>
                <th class="text-right">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($produkTerjual as $detail)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td>{{ $detail['produk_nama'] }}</td>
                    <td class="text-center">{{ $detail['total_jual'] }}</td>
                    <td class="text-right">Rp{{ number_format($detail['total_harga'], 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot class="grand-total">
            <tr>
                <th colspan="3">Grand Total</th>
                <th class="text-right">Rp{{ number_format($grandTotal, 0, ',', '.') }}</th>
            </tr>
        </tfoot>
    </table>

    <div class="admin-info">
        <p>Cimahi, {{ $tanggal }}</p>
        <p style="text-align: left;">Pencetak</p>
        <p class="text-sm italic" style="margin-top:50px; text-align: center;">
            <span class="font-bold">{{ auth()->user()->name }}</span>
        </p>
        <hr class="border-t-2 border-gray-300">
    </div>

    <script>
        window.onload = function() {
            window.print();
        };
    </script>

</body>
</html>
