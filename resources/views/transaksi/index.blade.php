@extends('component.layout')

@section('title', 'Data Penjualan')

@section('content')
    <div class="container mx-auto p-4">
        <div class="row">
            <div class="col-9">
                @if($transaksi->isEmpty())  <!-- Cek jika data transaksi kosong -->
                    <div class="card">
                        <p class="text-center text-gray-500 p-5">Belum ada data transaksi</p>
                    </div>
                @else
                <!-- Card Utama -->
                <div class="card mx-auto w-100 bg-white shadow-lg rounded-lg p-5">
                    <h1 class="text-3xl font-bold text-center mb-6">Data Penjualan</h1>
                    <hr class="mb-6">

                    <!-- Detail Penjualan -->
                    <div>
                        <div class="">
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
                                <tbody>
                                    @foreach ($transaksi as $item)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-4 py-2 border border-gray-300 text-center">{{ $item->penjualan_id }}</td>
                                            <td class="px-4 py-2 border border-gray-300">{{ $item->pelanggan->nama_pelanggan }}</td>
                                            <td class="px-4 py-2 border border-gray-300 text-center"> {{ \Carbon\Carbon::parse($item->tanggal_penjualan)->translatedFormat('j, F Y') }}</td>
                                            <td class="px-4 py-2 border border-gray-300 text-center">{{ $item->user->name }}</td>
                                            <td class="px-4 py-2 border border-gray-300 text-right">
                                                Rp{{ number_format($item->total_harga, 0, ',', '.') }}
                                            </td>
                                            <td>
                                                <div class="p-2 d-flex justify-content-center">
                                                <a href="{{ route('keranjang.struk', ['id_penjualan' => $item->penjualan_id]) }}" class="btn btn-primary btn-sm">Detail</a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                @endif
            </div>
            <div class="col-3">
                <div class="card">
                    <div class="p-3">
                        <h2 class="mb-5">Laporan</h2>
                        <form action="{{ route('laporan') }}" method="POST">
                            @csrf
                            <div class="mb-4">
                                <label for="bulan" class="block text-sm font-medium text-gray-700">Pilih Bulan</label>
                                <select id="bulan" name="bulan" class="block w-full mt-1 p-2 border border-gray-300 rounded" required>
                                    @php
                                        // Array of month names
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
                                        // Get the first transaction year or fallback to current year
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
                                <button type="submit" class="w-full p-2 bg-blue-600 hover:bg-blue-500 text-white rounded">Tampilkan Laporan</button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>

    </div>
@endsection
