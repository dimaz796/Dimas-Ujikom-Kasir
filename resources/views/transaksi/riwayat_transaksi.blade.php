@extends('component.layout')

@section('title', 'Riwayat Transaksi')

@section('content')
    <div class="container mx-auto p-4">
        <div class="row">
            <div class="col-12">

                <!-- Card Utama -->
                <div class="card mx-auto w-100 bg-white shadow-lg rounded-lg p-5">
                    <h1 class="text-3xl font-bold text-center mb-6">Riwayat Transaksi :  {{ auth()->user()->name }}</h1>
                    <hr class="mb-6">
 
                            <form method="GET" action="{{ route('riwayat_transaksi') }}" class="mb-4 flex items-center gap-3">
                                <div class="flex items-center space-x-2">
                                    <input type="date" id="start_date" name="start_date" value="{{ old('start_date', request('end_date')) }}"
                                        class="border border-gray-300 rounded-lg px-3 py-1 text-gray-700 text-sm w-32 focus:ring-2 focus:ring-blue-500 transition duration-150">
                                </div>

                                <div class="flex items-center space-x-2">
                                    <label for="end_date" class="text-gray-700 text-sm"> - </label>
                                    <input type="date" id="end_date" name="end_date" value="{{ old('end_date', request('end_date')) }}"
                                        class="border border-gray-300 rounded-lg px-3 py-1 text-gray-700 text-sm w-32 focus:ring-2 focus:ring-blue-500 transition duration-150">
                                </div>

                                <button type="submit" class="bg-blue-600 text-white px-4 py-1 rounded-lg text-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    Filter
                                </button>
                            </form>

                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

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
                                        <td colspan="6" class="px-4 py-2 text-center text-gray-500">Tidak ada data transaksi</td>
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

                                <tfoot class="bg-gray-100">
                                    <tr>
                                        <th colspan="4" class="px-4 py-2 border border-gray-300 text-center">Total Keseluruhan</th>
                                        <th colspan="2" class="px-4 py-2 border border-gray-300 text-center">Rp. {{ number_format($grandTotal) }}</th>
                                    </tr>
                                </tfoot>
                            @endif
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
