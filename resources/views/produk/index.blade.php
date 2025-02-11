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
    <div class="row mb-3">
        <!-- Kolom Kiri: Pencarian dan Restock -->
        <div class="col-9 d-flex align-items-center">
            <!-- Form Pencarian Produk -->
            <form action="{{ route('produk.search') }}" method="GET" class="d-flex me-2 w-50">
                <label for="simple-search" class="sr-only">Search</label>
                <div class="relative w-full">
                    <input type="text" name="search" id="simple-search"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                        placeholder="Cari Produk" />
                </div>
                <button type="submit"
                    class="p-2.5 ms-2 text-sm font-medium text-white bg-blue-700 rounded-lg border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300">
                    <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                    </svg>
                    <span class="sr-only">Search</span>
                </button>
            </form>
    
            @if($cekStok > 1)
                <!-- Tombol Restock -->
                <a href="{{ route('produk.restock') }}" class="btn btn-danger d-flex align-items-center position-relative ms-2">
                    <!-- SVG Icon for Cart -->
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m20.25 7.5-.625 10.632a2.25 2.25 0 0 1-2.247 2.118H6.622a2.25 2.25 0 0 1-2.247-2.118L3.75 7.5m6 4.125 2.25 2.25m0 0 2.25 2.25M12 13.875l2.25-2.25M12 13.875l-2.25 2.25M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z" />
                    </svg>
                    
        
                    <span id="jumlah-keranjang"
                        class="position-absolute top-0 start-100 translate-middle bg-gray-600 text-white rounded-full w-5 h-5 d-flex align-items-center justify-center text-xs">
                        {{ $cekStok }}
                    </span>
                </a>
            @endif

        </div>
    
        <!-- Kolom Kanan: Tambah Produk -->
        <div class="col-3 d-flex justify-content-end align-items-center">
            <a href="{{ route('produk.create') }}" class="btn btn-primary btn-md">Tambah Produk</a>
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
