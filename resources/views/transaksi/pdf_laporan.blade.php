@vite('resources/css/app.css')

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
<div class="container">
    <div class="card mt-3">
        <div class="p-3">
            <h2 class="text-2xl font-semibold mt-10 mb-4">Detail Penjualan Terlaris</h2>

            <!-- Tabel Detail Penjualan -->
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white border border-gray-300">
                    <thead>
                        <tr class="bg-gray-200 text-center">
                            <th class="px-4 py-2 border ">No</th>
                            <th class="px-4 py-2 border ">Produk</th>
                            <th class="px-4 py-2 border ">Jumlah Terjual</th>
                            <th class="px-4 py-2 border ">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($produkTerjual as $detail)
                            <tr class="text-center">
                                <td class="px-4 py-2 border ">{{ $loop->iteration }}</td>
                                <td class="px-4 py-2 border ">{{ $detail['produk_nama'] }}</td>
                                <td class="px-4 py-2 border ">{{ $detail['total_jual'] }}</td>
                                <td class="px-4 py-2 border ">Rp. {{ number_format($detail['total_harga'], 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="bg-gray-200 text-center">
                            <td colspan="3"><span class="fw-bold">Grand Total</span></td>
                            <td><span class="fw-bold"> Rp. {{ number_format($grandTotal, 0, ',', '.') }}</span></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
</html>
