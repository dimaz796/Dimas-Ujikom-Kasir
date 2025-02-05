@extends('component.layout')

@section('title', 'Beranda')

@section('content')

    <div class="card">
        <div class="p-3">

            <!-- Search Bar -->
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
                    <div class="d-flex me-auto">
                        <a href="{{ route('keranjang.index') }}" class="btn btn-primary ml-auto d-flex align-items-center">
                            Keranjang
                            <span id="jumlah-keranjang"
                                class="bg-red-600 text-white rounded-full w-8 h-8 d-flex items-center justify-center ms-2">{{ $jumlahKeranjang }}</span>
                        </a>
                    </div>

                </div>
            </div>


            <div class="row pt-3">
                <!-- Produk -->
                <div class="col-12">
                    <div class="row" id="produk-list">
                        @forelse($items as $item)
                            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 pt-3">
                                <div class="card shadow-lg d-flex flex-column">
                                    <a href="{{ route('produk.show', ['id' => $item->produk_id]) }}">
                                        <img src="{{ asset('storage/' . $item->foto) }}" alt=""
                                            class="card-img-top w-full" style="height: 150px; object-fit: cover;">
                                    </a>
                                    <div class="row ">
                                        <div class="col-12">
                                            <div class="fw-semibold ps-2 text-lg font-inter text-truncate" style="max-width: 100%;">
                                                {{ $item->nama_produk }}</div>
                                        </div>
                                        <div class="col-6">
                                            <div class="ps-2 font-semibold font-inter text-blue-700">Rp. {{ number_format($item->harga) }}</div>
                                        </div>
                                        <div class="col-6">
                                            <small class="pl-2 font-semibold text-right">
                                                Stok : {{ $item->stok }}
                                            </small>
                                        </div>
                                        <div class="col-span-2 px-3 pb-1 pt-2">
                                            <button class="btn btn-primary w-full tambah-keranjang"
                                                data-produk-id="{{ $item->produk_id }}"><small>Tambah</small></button>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        @empty
                            <div class="col-auto">
                                <p>Produk Tidak Ada</p>
                            </div>
                        @endforelse
                    </div>
                </div>



            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).ready(function() {
            // Menangani klik tombol "Tambah"
            $('.tambah-keranjang').on('click', function() {
                var produkId = $(this).data('produk-id'); // Mendapatkan ID produk dari data atribut

                // Mengirim permintaan AJAX ke server
                $.ajax({
                    url: '{{ route('keranjang') }}', // URL route untuk menambahkan produk ke keranjang
                    type: 'POST',
                    data: {
                        produk_id: produkId,
                        _token: '{{ csrf_token() }}', // Pastikan CSRF token disertakan untuk keamanan
                    },
                    success: function(response) {
                        if (response.status === 'success') {

                            // Update keranjang
                            $('#keranjang-list').html(response.keranjang);

                            // Update jumlah keranjang
                            $('#jumlah-keranjang').text(response.jumlahKeranjang);
                        } else {
                            // Menampilkan pesan error spesifik dari server
                            alert(response.message); // Pesan seperti "Stok habis"
                        }
                    },

                    error: function() {
                        console.log(xhr.responseText);
                        alert('Terjadi kesalahan saat menambahkan produk');
                    }
                });
            });
        });
    </script>
@endsection
