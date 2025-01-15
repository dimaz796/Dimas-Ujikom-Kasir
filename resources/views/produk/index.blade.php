@extends('component.layout')

@section('title', 'Daftar Produk')

@section('content')
    <h1>Daftar Produk</h1>
    <a href=" {{ route('produk.create') }} " class="btn btn-success btn-sm mb-3">Tambah Produk</a>
    <table class="table">
        <thead class="table-dark">
            <tr>
                <th>No</th>
                <th>Nama Produk</th>
                <th>Harga</th>
                <th>Stok</th>
                <th>Foto</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($produk as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->nama_produk }}</td>
                    <td>{{ $item->harga }}</td>
                    <td>{{ $item->stok }}</td>
                    <td> 
                        <img src="{{ asset('storage/' . $item->foto) }}" alt="Foto Produk" class="img-fluid" alt="Responsive image" style="width:50px; height: 50px;">
                    </td>
                    <td>
                        <a href="{{ route('produk.edit', ['id' => $item->produk_id]) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('produk.delete', ['id' => $item->produk_id]) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">Tidak ada produk</td>
                </tr>
            @endforelse
        </tbody>
    </table>

@endsection
