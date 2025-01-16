@extends('component.layout')

@section('title', 'Produk')

@section('content')
<div class="container mx-auto p-6">
        <!-- Card Produk -->
        <div class="bg-white shadow-lg rounded-lg overflow-hidden max-w-md mx-auto">
            <!-- Gambar Produk -->
            <img src="{{ asset('storage/' . $produk->foto) }}" alt="{{ $produk->nama_produk }}" class="w-full h-96 object-cover">

            <!-- Isi Card -->
            <div class="p-6">
                <h1 class="text-2xl font-semibold text-gray-800">{{ $produk->nama_produk }}</h1>
                
                <p class="text-xl font-bold text-blue-600 mt-2">Rp. {{ number_format($produk->harga) }}</p>

                <p class="text-sm text-gray-500">Stok: {{ $produk->stok }}</p>

                <div class="mb-4">
                    <a href="{{ route('home') }}" class="no-underline inline-block px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-blue-300">
                        Kembali ke Home
                    </a>
                </div>
            </div>
        </div>
    </div>

@endsection
