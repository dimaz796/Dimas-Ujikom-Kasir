@extends('component.layout')

@section('title', 'Data Penjualan')

@section('content')
    <div class="container mx-auto p-4">
        <div class="row">
            <div class="col-9">

                <div class="card mx-auto w-100 bg-white shadow-lg rounded-lg p-5">
                    <h1 class="text-3xl font-bold text-center mb-6">Data Penjualan</h1>
                    <hr class="mb-6">
                    <div class="row">
                        <div class="col-12 col-md-9">
                            <form method="GET" action="{{ route('transaksi') }}" class="mb-4 d-flex flex-column flex-md-row gap-3">
                                <div class="d-flex flex-column flex-md-row align-items-start gap-2">
                                    <input placeholder="" type="date" id="start_date" name="start_date" value="{{ old('start_date', request('end_date')) }}"
                                        class="form-control form-control-sm w-100 w-md-32">
                                </div>

                                <div class="d-flex flex-column flex-md-row align-items-start gap-2">
                                    <label for="end_date" class="text-gray-700 text-sm fw-bold"> - </label>

                                </div>

                                <div class="d-flex flex-column flex-md-row align-items-start gap-2">
                                    <input type="date" id="end_date" name="end_date" value="{{ old('end_date', request('end_date')) }}"
                                        class="form-control form-control-sm w-100 w-md-32">
                                </div>

                                <div class="d-flex flex-column flex-md-row align-items-end gap-2">
                                    <input type="text" id="search" name="search"
                                        placeholder="Cari transaksi..."
                                        value="{{ old('search', request('search')) }}"
                                        class="form-control form-control-sm w-100 w-md-32">
                                </div>
                                <button type="submit" class="btn btn-primary btn-sm">
                                    Filter
                                </button>

                            </form>
                        </div>
                        <div class="col-12 col-md-12 col-lg-3">
                            <div class="d-flex justify-content-md-start justify-content-lg-end">
                                <a href="{{ ($startDate || $endDate || $search) && !$isDisabled && !$transaksi->isEmpty()
                                            ? route('transaksi.printPDF', [
                                                'start_date' => $startDate,
                                                'end_date' => $endDate,
                                                'search' => $search
                                              ])
                                            : '#' }}"
                                    class="no-underline bg-red-600 text-white px-4 py-1 rounded-lg text-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-blue-500
                                           {{ !($startDate || $endDate || $search) || $isDisabled || $transaksi->isEmpty() ? 'cursor-not-allowed opacity-50 pointer-events-none' : '' }}">
                                    Print PDF
                                </a>
                            </div>
                        </div>

                    </div>
                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <div class="mt-3 overflow-x-auto">
                        <table class="w-full table-auto border-collapse border border-gray-300 ">
                            <thead class="bg-gray-100">
                                <tr>

                                    <th class="px-4 py-2 border border-gray-300 text-center">No</th>
                                    <th class="px-4 py-2 border border-gray-300 text-center">No Transaksi</th>
                                    <th class="px-4 py-2 border border-gray-300 text-center">Nama Pelanggan</th>
                                    <th class="px-4 py-2 border border-gray-300 text-center">Tanggal</th>
                                    <th class="px-4 py-2 border border-gray-300 text-center">Kasir</th>
                                    <th class="px-4 py-2 border border-gray-300 text-center">Total</th>
                                    <th class="px-4 py-2 border border-gray-300 text-center">Aksi</th>
                                </tr>
                            </thead>

                            @if($transaksi->isEmpty())
                                <tbody>
                                    <tr>
                                        <td colspan="6" class="px-4 py-2 text-center text-gray-500">Tidak ada data transaksi</td>
                                    </tr>
                                </tbody>
                            @else
                                <tbody>
                                    @foreach ($transaksi as $item)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-4 py-2 border border-gray-300 text-center">{{ $loop->iteration }}</td>
                                            <td class="px-4 py-2 border border-gray-300 text-center">{{ $item->penjualan_id }}</td>
                                            <td class="px-4 py-2 border border-gray-300">{{ $item->pelanggan->nama_pelanggan?? '-' }}</td>
                                            <td class="px-4 py-2 border border-gray-300 text-center">
                                                {{ \Carbon\Carbon::parse($item->tanggal_penjualan)->translatedFormat('j, F Y') }}
                                            </td>
                                            <td class="px-4 py-2 border border-gray-300 text-center">{{ $item->user->name }}</td>
                                            <td class="px-4 py-2 border border-gray-300 text-right">
                                                Rp{{ number_format($item->total_harga, 0, ',', '.') }}
                                            </td>
                                            <td class="px-4 py-2 border border-gray-300 text-center">
                                                @if(optional($item->produk)->isEmpty())
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

                                <tfoot class="bg-gray-100">
                                    <tr>
                                        <th colspan="4" class="px-4 py-2 border border-gray-300 text-center">Total Keseluruhan</th>
                                        <th colspan="2" class="px-4 py-2 border border-gray-300 text-center">Rp. {{ number_format($grandTotal) }}</th>
                                    </tr>
                                </tfoot>
                            @endif
                        </table>
                        {{-- <div class="mt-4">
                            {{ $transaksi->links() }}
                        </div> --}}
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
