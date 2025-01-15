@extends('component.layout')

@section('title', 'Tambah Produk')

@section('content')
<div class="container ">
    <div class="card p-3" style="width: 100%;">
        <h2 class="pb-3">Tambah Produk</h2>
        <div class="row">
            <div class="col-6">
                <form action="{{ route('produk.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                       <input type="text" name="nama_produk" placeholder="Nama Produk" required class="form-control">
                    </div>
                    <div class="mb-3">
                       <input type="number" name="harga" placeholder="Harga Produk" required class="form-control">
                    </div>
                    <div class="mb-3">
                       <input type="number" name="stok" placeholder="Stok Produk" required class="form-control">
                    </div>
                    <div class="mb-3">
                       <input type="file" name="foto" class="form-control">
                    </div>

                    <button type="submit" class="btn btn-primary">Tambah</button>
                </form>
            </div>
        </div>
    </div>
</div>
    

@endsection
