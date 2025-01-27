@extends('component.layout')

@section('title', 'Struk')

@section('content')
    <div class="container mx-auto p-4">
        <!-- Card Utama -->
        <div class="card mx-auto w-75 bg-white shadow-lg rounded-lg p-5">
            <h1 class="text-3xl font-bold text-center mb-6">Struk Penjualan</h1>
            <hr class="mb-6">

            <!-- Informasi Pelanggan dan Penjualan -->
            <div class="grid grid-cols-2 gap-6 mb-6">
                <!-- Kolom Informasi Pelanggan -->
                <div>
                    <div class="space-y-3">
                        <div class="grid grid-cols-3">
                            <span class="fw-medium">Nama Pelanggan</span>
                            <span class="col-span-2 break-words">: {{ $pelanggan->nama_pelanggan }}</span>
                        </div>
                        <div class="grid grid-cols-3">
                            <span class="fw-medium">Alamat</span>
                            <span class="col-span-2 break-words">: {{ $pelanggan->alamat_pelanggan }}</span>
                        </div>
                        <div class="grid grid-cols-3">
                            <span class="fw-medium">Nomor Telepon</span>
                            <span class="col-span-2">: {{ $pelanggan->nomor_telepon }}</span>
                        </div>
                    </div>
                </div>
            
                <!-- Kolom Informasi Penjualan -->
                <div>
                    <div class="space-y-3">
                        <div class="grid grid-cols-3">
                            <span class="fw-medium">ID Penjualan</span>
                            <span class="col-span-2">: {{ $penjualan->penjualan_id }}</span>
                        </div>
                        <div class="grid grid-cols-3">
                            <span class="fw-medium">Tanggal Penjualan</span>
                            <span class="col-span-2">: {{ $penjualan->tanggal_penjualan }}</span>
                        </div>
                    </div>
                </div>
            </div>
            

            <hr>
            <!-- Detail Penjualan -->
            <div>
                <h2 class="text-2xl font-semibold mb-4">Detail Penjualan</h2>
                <div class="overflow-x-auto">
                    <table class="w-full table-auto border-collapse border border-gray-300">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-4 py-2 border border-gray-300 text-left">No</th>
                                <th class="px-4 py-2 border border-gray-300 text-left">Nama Produk</th>
                                <th class="px-4 py-2 border border-gray-300 text-center">Jumlah</th>
                                <th class="px-4 py-2 border border-gray-300 text-right">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($detailPenjualan as $detail)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-2 border border-gray-300 text-center">{{ $loop->iteration }}</td>
                                    <td class="px-4 py-2 border border-gray-300">{{ $detail->produk->nama_produk }}</td>
                                    <td class="px-4 py-2 border border-gray-300 text-center">{{ $detail->jumlah_produk }}</td>
                                    <td class="px-4 py-2 border border-gray-300 text-right">
                                        Rp{{ number_format($detail->subtotal, 0, ',', '.') }}
                                    </td>
                                </tr>
                            @endforeach
                            <!-- Baris Total -->
                            <tr class="font-semibold bg-gray-100">
                                <td colspan="3" class="px-4 py-2 border fw-bold border-gray-300 text-right">Total</td>
                                <td class="px-4 py-2 border border-gray-300 text-right">
                                    Rp{{ number_format($penjualan->total_harga, 0, ',', '.') }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="flex justify-center pt-5">
            <a href="{{ route('home') }}" class="btn btn-primary w-25 ">Kembali Ke Beranda</a>
        </div>
        </div>
    </div>
@endsection
