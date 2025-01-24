@extends('component.layout')

@section('title', 'Data Penjualan')

@section('content')
    <div class="container mx-auto p-4">
        <!-- Card Utama -->
        <div class="card mx-auto w-75 bg-white shadow-lg rounded-lg p-5">
            <h1 class="text-3xl font-bold text-center mb-6">Data Penjualan</h1>
            <hr class="mb-6">

            <!-- Detail Penjualan -->
            <div>
                <div class="overflow-x-auto">
                    <table class="w-full table-auto border-collapse border border-gray-300">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-4 py-2 border border-gray-300 text-left">No Transaksi</th>
                                <th class="px-4 py-2 border border-gray-300 text-left">Nama Pelanggan</th>
                                <th class="px-4 py-2 border border-gray-300 text-center">Tanggal</th>
                                <th class="px-4 py-2 border border-gray-300 text-right">Kasir</th>
                                <th class="px-4 py-2 border border-gray-300 text-right">Total</th>
                                <th class="px-4 py-2 border border-gray-300 text-right">Aksi</th>
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
                                        <div class="p-2">
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
    </div>
@endsection
