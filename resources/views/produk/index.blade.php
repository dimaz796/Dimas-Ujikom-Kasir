@extends('component.layout')

@section('title', 'Daftar Produk')

@section('content')
    <h1>Daftar Produk</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    <div class="row">
        <div class="col-6">
            <form action="{{ route('produk.search') }}" method="GET" class="flex items-start max-w-sm">
                <label for="simple-search" class="sr-only">Search</label>
                <div class="relative w-full">
                    <input type="text" name="search" id="simple-search"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                        placeholder="Cari Produk" />
                </div>
                <button type="submit"
                    class="p-2.5 ms-2 text-sm font-medium text-white bg-blue-700 rounded-lg border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300">
                    <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                    </svg>
                    <span class="sr-only">Search</span>
                </button>
            </form>
        </div>
        <div class="col-6">
           <div class="d-flex justify-content-end">
                <a href=" {{ route('produk.create') }} " class="btn btn-primary btn-md mb-3">Tambah Produk</a>
           </div>
        </div>
    </div>

    <table class="table rounded-lg overflow-hidden shadow-lg text-center">
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
                    <td class="text-left"><span class="fw-semibold">{{ $item->nama_produk }}</span></td>

                    <td>Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                    <td>{{ $item->stok }}</td>
                    <td>
                        <div class="d-flex justify-content-center">
                            <img src="{{ asset('storage/' . $item->foto) }}" alt="Foto Produk" class="img-fluid" alt="Responsive image" style="width:50px; height: 50px;">
                        </div>
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
