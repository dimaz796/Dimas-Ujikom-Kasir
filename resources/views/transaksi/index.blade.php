@extends('component.layout')

@section('title', 'Data Penjualan')

@section('content')
    <div class="container mx-auto p-4">
        <div class="row">
            <div class="col-9">

                <!-- Card Utama -->
                <div class="card mx-auto w-100 bg-white shadow-lg rounded-lg p-5">
                    <h1 class="text-3xl font-bold text-center mb-6">Data Penjualan</h1>
                    <hr class="mb-6">
                    <div class="row">
                        <div class="col-9">
                            <form method="GET" action="{{ route('transaksi') }}" class="mb-4 flex items-center gap-3">
                                <div class="flex items-center space-x-2">
                                    <input type="date" id="start_date" name="start_date" value="{{ request('start_date') }}"
                                        class="border border-gray-300 rounded-lg px-3 py-1 text-gray-700 text-sm w-32 focus:ring-2 focus:ring-blue-500 transition duration-150">
                                </div>

                                <div class="flex items-center space-x-2">
                                    <label for="end_date" class="text-gray-700 text-sm"> - </label>
                                    <input type="date" id="end_date" name="end_date" value="{{ request('end_date') }}"
                                        class="border border-gray-300 rounded-lg px-3 py-1 text-gray-700 text-sm w-32 focus:ring-2 focus:ring-blue-500 transition duration-150">
                                </div>

                                <button type="submit" class="bg-blue-600 text-white px-4 py-1 rounded-lg text-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    Filter
                                </button>
                            </form>
                        </div>
                        <div class="col-3">
                            <div class="d-flex justify-content-end">
                                <a href="{{ $isDisabled ? '#' : route('transaksi.printPDF', ['start_date' => $startDate, 'end_date' => $endDate]) }}"
                                    class="no-underline bg-red-600 text-white px-4 py-1 rounded-lg text-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-blue-500 {{ $isDisabled ? 'cursor-not-allowed opacity-50' : '' }}"
                                    {{ $isDisabled ? 'disabled' : '' }}>
                                    Print PDF
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Detail Penjualan -->
                    <div>
                        <table class="w-full table-auto border-collapse border border-gray-300">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="px-4 py-2 border border-gray-300 text-center">No Transaksi</th>
                                    <th class="px-4 py-2 border border-gray-300 text-center">Nama Pelanggan</th>
                                    <th class="px-4 py-2 border border-gray-300 text-center">Tanggal</th>
                                    <th class="px-4 py-2 border border-gray-300 text-center">Kasir</th>
                                    <th class="px-4 py-2 border border-gray-300 text-center">Total</th>
                                    <th class="px-4 py-2 border border-gray-300 text-center">Aksi</th>
                                </tr>
                            </thead>

                            @if($transaksi->isEmpty())  <!-- Cek jika data transaksi kosong -->
                                <tbody>
                                    <tr>
                                        <td colspan="6" class="px-4 py-2 text-center text-gray-500">Belum ada data transaksi</td>
                                    </tr>
                                </tbody>
                            @else
                                <tbody>
                                    @foreach ($transaksi as $item)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-4 py-2 border border-gray-300 text-center">{{ $item->penjualan_id }}</td>
                                            <td class="px-4 py-2 border border-gray-300">{{ $item->pelanggan->nama_pelanggan }}</td>
                                            <td class="px-4 py-2 border border-gray-300 text-center">
                                                {{ \Carbon\Carbon::parse($item->tanggal_penjualan)->translatedFormat('j, F Y') }}
                                            </td>
                                            <td class="px-4 py-2 border border-gray-300 text-center">{{ $item->user->name }}</td>
                                            <td class="px-4 py-2 border border-gray-300 text-right">
                                                Rp{{ number_format($item->total_harga, 0, ',', '.') }}
                                            </td>
                                            <td class="px-4 py-2 border border-gray-300 text-center">
                                                @if(optional($item->produk)->isEmpty()) <!-- Check if produk is empty -->
                                                    Tidak ada transaksi
                                                @else
                                                    <div class="p-2 d-flex justify-content-center">
                                                        <a href="{{ route('keranjang.struk', ['id_penjualan' => $item->penjualan_id]) }}" class="btn btn-primary btn-sm">Detail</a>
                                                    </div>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            @endif
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-3">
                <div class="card">
                    <div class="p-3">
                        <div class="mb-5 fw-semibold text-lg">Laporan Penjualan Barang</div>
                        <form action="{{ route('laporan') }}" method="POST">
                            @csrf
                            <div class="mb-4">
                                <label for="bulan" class="block text-sm font-medium text-gray-700">Pilih Bulan</label>
                                <select id="bulan" name="bulan" class="block w-full mt-1 p-2 border border-gray-300 rounded" required>
                                    @php
                                        $months = [
                                            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
                                            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
                                            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
                                        ];
                                    @endphp
                                    <option value="" selected disabled>Pilih Bulan</option>
                                    @foreach($distinctMonths as $monthNumber)
                                        <option value="{{ $monthNumber }}" {{ $monthNumber == $currentMonth ? 'selected' : '' }}>
                                            {{ $months[$monthNumber] }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-4">
                                <label for="tahun" class="block text-sm font-medium text-gray-700">Pilih Tahun</label>
                                <select id="tahun" name="tahun" class="block w-full mt-1 p-2 border border-gray-300 rounded" required>
                                    @php
                                        $firstTransactionYear = $firstTransactionYear ?? $currentYear;
                                    @endphp
                                    <option value="" selected disabled>Pilih Tahun</option>
                                    @for ($year = $firstTransactionYear; $year <= $currentYear; $year++)
                                        <option value="{{ $year }}" {{ $year == $currentYear ? 'selected' : '' }}>
                                            {{ $year }}
                                        </option>
                                    @endfor
                                </select>
                            </div>

                            <div class="mb-4">
                                <button type="submit" class="w-full p-2 bg-blue-600 hover:bg-blue-500 text-white rounded">Tampilkan Laporan Produk Terjual</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
