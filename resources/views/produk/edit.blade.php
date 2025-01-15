@extends('component.layout')

@section('title', 'Daftar Produk')

@section('content')
<div class="container ">
    <div class="card p-3" style="width: 100%;">
        <h2 class="pb-3">Edit Produk</h2>
        <div class="row">
            <div class="col-6">
                <form action="{{ route('produk.update',['id' => $produk->produk_id]) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                       <input type="text" name="nama_produk" value="{{ $produk->nama_produk }}" placeholder="Nama Produk" required class="form-control">
                    </div>
                    <div class="mb-3">
                       <input type="number" name="harga" value="{{ $produk->harga }}" placeholder="Harga Produk" required class="form-control">
                    </div>
                    <div class="mb-3">
                       <input type="number" name="stok" value="{{ $produk->stok }}" placeholder="Stok Produk" required class="form-control">
                    </div>
                    <div class="mb-3">
                       <input type="file" name="foto" value="{{ $produk->foto }}" class="form-control">
                    </div>

                    <button type="submit" class="btn btn-primary">Tambah</button>
                </form>
            </div>
        </div>
    </div>
</div>
    

@endsection
