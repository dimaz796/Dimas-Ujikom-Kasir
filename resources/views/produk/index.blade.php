@extends('component.layout')

@section('title', 'Daftar Produk')

@section('content')
    <h1>Daftar Produk</h1>
    <a href=" {{ route('produk.create') }} " class="btn btn-primary btn-sm mb-3">Tambah Produk</a>
    <table class="table rounded-lg overflow-hidden shadow-lg">
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
        <tbody class="table-light">
            @forelse ($produk as $item)
                <tr>
                    <td>{{ $produk->firstItem() + $loop->iteration - 1 }}</td>
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

    <div class="d-flex justify-content-end mt-3">
        {{ $produk->links() }}
    </div>

@endsection
