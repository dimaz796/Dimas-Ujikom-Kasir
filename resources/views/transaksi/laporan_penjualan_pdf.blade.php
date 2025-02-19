<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Penjualan</title>
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
    <h2 class="text-center title">Laporan Transaksi Samquik</h2>
    <p class="address">
        {{ $alamat }}
    </p>
    <p class="address">
        Telephone {{ $telephone }}
    </p>

    <div class="separator"></div>

    <h2 class="text-center">Data Penjualan</h2>
    <!-- Rentang Tanggal -->
    @if($startDate && $endDate)
        <h2 class="text-center"> {{ \Carbon\Carbon::parse($startDate)->translatedFormat('j F Y') }} - {{ \Carbon\Carbon::parse($endDate)->translatedFormat('j F Y') }}</h2>
    @elseif($startDate)
        <h2 class="text-center"> {{ \Carbon\Carbon::parse($startDate)->translatedFormat('j F Y') }}</h2>
    @elseif($endDate)
        <h2 class="text-center"> {{ \Carbon\Carbon::parse($endDate)->translatedFormat('j F Y') }}</h2>
    @endif


    <!-- Tabel Transaksi -->
    <table class="table">
        <thead>
            <tr>
                <th>No Transaksi</th>
                <th>Nama Pelanggan</th>
                <th>Tanggal</th>
                <th>Kasir</th>
                <th>Produk</th>
                <th>Jumlah</th>
                <th>Subtotal</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($transaksi as $item)
                @php
                    $detailCount = $item->detailPenjualan->count(); // Count the number of detailPenjualan
                @endphp
                @foreach ($item->detailPenjualan as $key => $detail)
                    <tr>
                        @if ($key == 0) <!-- Apply rowspan only for the first row -->
                            <td rowspan="{{ $detailCount }}">{{ $item->penjualan_id }}</td>
                            <td rowspan="{{ $detailCount }}">{{ $item->pelanggan->nama_pelanggan }}</td>
                            <td rowspan="{{ $detailCount }}">{{ Carbon\Carbon::parse($item->tanggal_penjualan)->translatedFormat('j, F Y') }}</td>
                            <td rowspan="{{ $detailCount }}">{{ $item->user->name }}</td>
                         @endif
                         <td>{{ $detail->produk->nama_produk }}</td>
                         <td class="text-right">{{ $detail->jumlah_produk }}</td>
                         <td class="text-right">Rp{{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                         @if ($key == 0) <!-- Apply rowspan only for the first row -->
                            <td rowspan="{{ $detailCount }}" class="text-right">Rp{{ number_format($item->total_harga, 0, ',', '.') }}</td>
                         @endif
                    </tr>
                @endforeach
            @endforeach
        </tbody>
        <tfoot class="grand-total">
            <tr>
                <th colspan="7">Grand Total</th>
                <th class="text-right">Rp{{ number_format($transaksi->sum('total_harga'), 0, ',', '.') }}</th>
            </tr>
        </tfoot>
    </table>

    <div class="admin-info">
        <p>Cimahi, {{ $tanggal }}</p>
        <p style="text-align: left;">Pencetak</p>
        <p class="text-sm italic" style="margin-top:50px; text-align: center;"><span class="font-bold">{{ auth()->user()->name }}</span></p>
        <hr class="border-t-2 border-gray-300">
    </div>

</body>
</html>
