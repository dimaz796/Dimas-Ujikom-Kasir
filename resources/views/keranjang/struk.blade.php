@extends('component.layout')

@section('title', 'Edit Produk')

@section('content')
    <div class="container mx-auto p-6">
        <h1 class="text-3xl font-bold text-center mb-6">Struk Penjualan</h1>

        <!-- Informasi Penjualan -->
        <div class="mb-8">
            <h2 class="text-2xl font-semibold mb-4">Informasi Penjualan</h2>
            <div class="flex flex-col space-y-2">
                <p><strong>ID Penjualan:</strong> {{ $penjualan->penjualan_id }}</p>
                <p><strong>Tanggal Penjualan:</strong> {{ $penjualan->tanggal_penjualan }}</p>
            </div>
        </div>

        <!-- Informasi Pelanggan -->
        <div class="mb-8">
            <h2 class="text-2xl font-semibold mb-4">Informasi Pelanggan</h2>
            <div class="flex flex-col space-y-2">
                <p><strong>Nama Pelanggan:</strong> {{ $pelanggan->nama_pelanggan }}</p>
                <p><strong>Alamat:</strong> {{ $pelanggan->alamat_pelanggan }}</p>
                <p><strong>Nomor Telepon:</strong> {{ $pelanggan->nomor_telepon }}</p>
            </div>
        </div>

        <!-- Detail Penjualan -->
        <div class="mb-8 w-full">
            <h2 class="text-2xl font-semibold mb-4">Detail Penjualan</h2>
            <table class="min-w-full table-auto border border-gray-300">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-2 border border-gray-300 text-left">No</th>
                        <th class="px-4 py-2 border border-gray-300 text-left">Nama Produk</th>
                        <th class="px-4 py-2 border border-gray-300 text-left">Jumlah</th>
                        <th class="px-4 py-2 border border-gray-300 text-left">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($detailPenjualan as $detail)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-2 border border-gray-300 text-center">{{ $loop->iteration }}</td>
                            <td class="px-4 py-2 border border-gray-300">{{ $detail->produk->nama_produk }}</td>
                            <td class="px-4 py-2 border border-gray-300 text-center">{{ $detail->jumlah_produk }}</td>
                            <td class="px-4 py-2 border border-gray-300 text-right">
                                Rp{{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                    <!-- Baris Total -->
                    <tr class="font-semibold bg-gray-100">
                        <td colspan="3" class="px-4 py-2 border border-gray-300 text-right">Total</td>
                        <td class="px-4 py-2 border border-gray-300 text-right">
                            Rp{{ number_format($penjualan->total_harga, 0, ',', '.') }}</td>
                    </tr>
                </tbody>
            </table>

        </div>

    </div>




@endsection
