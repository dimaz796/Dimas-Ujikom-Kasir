@extends('component.layout')

@section('title', 'Stok Produk')

@section('content')
<div class="container ">
    <div class="card p-3" style="width: 100%;">
        <h2 class="pb-3">Stok Produk</h2>
        <div class="row">
            <div class="col-6">
                <form action="{{ route('produk.updateStock')}}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <input type="hidden" name="produk_id" value="{{ $produk->produk_id }}">
                    <img src="{{ asset('storage/' . $produk->foto) }}" alt="{{ $produk->nama_produk }}" class="w-full h-96 object-cover">


                    <div class="p-6">
                        <h1 class="text-2xl font-semibold text-gray-800">{{ $produk->nama_produk }}</h1>

                        <div class="mb-3 mt-3">
                            <input type="number" name="stok_tambahan" placeholder="Tambah Stok Produk" required class="form-control">
                        </div>

                        <button type="submit" class="btn btn-primary mb-2">Tambah Stok</button>
                    </div>
            </div>
        </div>
    </div>
</div>


@endsection
