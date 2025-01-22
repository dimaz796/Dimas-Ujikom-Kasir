@extends('component.layout')

@section('title','Beranda')

@section('content')

<div class="card">
    <div class="p-3">

        <!-- Search Bar -->
        <form action="{{ route('produk.search') }}" method="GET" class="flex items-start max-w-sm">
            <label for="simple-search" class="sr-only">Search</label>
            <div class="relative w-full">
                <input type="text" name="search" id="simple-search" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="Cari Produk" />
            </div>
            <button type="submit" class="p-2.5 ms-2 text-sm font-medium text-white bg-blue-700 rounded-lg border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300">
                <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                </svg>
                <span class="sr-only">Search</span>
            </button>
        </form>

        <div class="row pt-3">
            <!-- Produk -->
            <div class="col-7">
                <div class="row" id="produk-list">
                    @forelse($items as $item)
                    <div class="col-4 pt-3">
                    <div class="card shadow-lg d-flex flex-column">
                        <a href="{{ route('produk.show', ['id'=> $item->produk_id]) }}">
                            <img src="{{ asset('storage/' . $item->foto) }}" alt="" class="card-img-top w-full" style="height: 150px; object-fit: cover;">
                        </a>
                        <div class="row flex-grow-1 d-flex flex-column">
                            <div class="col-12">
                                <div class="fw-semibold ps-2 text-truncate" style="max-width: 100%;">{{ $item->nama_produk }}</div>
                            </div>
                            <div class="col-12">
                                <div class="ps-2">Rp. {{ number_format($item->harga) }}</div>
                            </div>
                            <div class="col-12">
                                <small class="ps-2 fw-semibold">
                                    Stok : {{ $item->stok }}
                                </small>
                            </div>
                            <div class="col-span-2 px-3 pb-1 pt-2">
                                <button class="btn btn-primary w-full tambah-keranjang" data-produk-id="{{ $item->produk_id }}"><small>Tambah</small></button>
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

            <!-- Struk -->
            <div class="col-5">
                <div class="card">
                    <!-- Nomor Transaksi -->
                    <div class="p-2">
                      <h4 class="fw-semibold text-blue-700">Samquik</h4>
                      <div>Tanggal : <span id="current-time"></span></div>
                      <div >Nomor : {{ $jumlahTransaksi }}</div>
                        <hr>
                    </div>

                    <!-- Keranjang Pembelian -->
                    <div class="p-2 max-h-[200px] overflow-y-auto overflow-x-hidden border-2 bg-gray-50" id="keranjang-list">
                        @forelse($keranjang as $item)
                        <div class="flex items-center w-full space-x-2 pt-2">
                            <!-- Produk dan Tombol -->
                            <div class="flex items-center w-64 h-20">
                                <div class="bg-gray-50 border w-full">
                                    <div class="p-2">
                                        <div class="flex items-center w-full">
                                            <!-- Gambar Produk -->
                                            <div class="flex-none w-13">
                                                <img src="{{ asset('storage/' . $item['foto']) }}" alt="" class="rounded-full object-cover" style="width: 50px;height: 50px;">
                                            </div>

                                            <!-- Nama Produk dan Harga -->
                                            <div class="flex-none w-20 ml-2">
                                                <div class="font-medium text-truncate whitespace-nowrap overflow-hidden" style="max-width: 100%;">
                                                    {{ Str::words($item['nama_produk'], 2) }}
                                                </div>
                                                <div class="text-xs text-gray-500 w-full">Rp. {{ number_format($item['harga']) }}</div>
                                            </div>

                                            <!-- Tombol +, - dan Jumlah Produk -->
                                            <div class="ml-auto flex items-center space-x-5">
                                                <div class="w-36 pt-2 pl-1 pr-1 flex space-x-1">
                                                    <button type="button" class="px-2 py-1 text-xs font-medium text-center text-white bg-blue-700 rounded-sm hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300" data-id="{{ $item['produk_id'] }}">-</button>
                                                    <span class="w-7 px-2 py-1 text-xs font-medium text-center text-blue-700 bg-gray-300 rounded-sm border-1 border-blue-700 hover:bg-gray-400 focus:ring-4 focus:outline-none focus:ring-blue-300 cursor-pointer">
                                                        {{ $item['jumlah'] }}
                                                    </span>
                                                    <button type="button" class="px-2 py-1 text-xs font-medium text-center text-white bg-blue-700 rounded-sm hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300" data-id="{{ $item['produk_id'] }}">+</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Total Harga -->
                            <div class="flex items-center w-1/4">
                                <div class="bg-gray-50 border w-full h-full">
                                    <div class="px-2 py-3 w-48">
                                        <span class="text-sm font-semibold">Rp. {{ number_format($item['harga'] * $item['jumlah']) }}</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Ikon Hapus -->
                            <div class="flex items-center justify-center w-1/12">
                                <div class="bg-gray-50 border w-full">
                                    <div class="px-2 py-3">
                                        <span class="text-center text-sm font-semibold text-red-900">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                            </svg>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @empty
                            <div class="card">
                                Belum Ada Produk Yang Di Pesan
                            </div>
                        @endforelse
                    </div>


                    <!-- Data Pelanggan -->
                    <div class="p-2 pt-4">
                        <div class="bg-gray-50 border-2 p-2">
                            <div class="fw-semibold">Data Pelanggan</div>
                            <div class="py-1">
                                <input type="text" class="form-control" placeholder="Nama Pelanggan" name="nama_pelanggan">
                            </div>
                            <div class="py-1">
                                <input type="text" class="form-control" placeholder="Nama Pelanggan" name="nama_pelanggan">
                            </div>
                            <div class="py-1">
                                <input type="number" class="form-control" placeholder="No Telephone" name="nomor_telepone">
                            </div>
                            <div class="flex">
                                <div class="flex-initial  w-50 p-1"><button class="btn btn-primary">Bayar Sekarang</button></div>
                                <div class="flex flex-col justify-end items-end ms-auto">
                                    <div class="fw-semibold p-1 text-xl">Rp. {{ number_format($item->harga ?? 0 ) }}</div>
                                </div>
                            </div>
                        </div>
                    </div>

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
                var produkId = $(this).data('produk-id');  // Mendapatkan ID produk dari data atribut

                // Mengirim permintaan AJAX ke server
                $.ajax({
                    url: '{{ route('keranjang') }}',  // URL route untuk menambahkan produk ke keranjang
                    type: 'POST',
                    data: {
                        produk_id: produkId,
                        _token: '{{ csrf_token() }}',  // Pastikan CSRF token disertakan untuk keamanan
                    },
                    success: function(response) {
                        if (response.status == 'success') {
                            alert(response.message);  // Menampilkan pesan sukses

                            $('#keranjang-list').html(response.keranjang);
                            $('#produk-list').html(response.produk);
                        } else {
                            alert('Terjadi kesalahan');
                        }
                    },
                    error: function() {
                        console.log(xhr.responseText);
                        alert('Terjadi kesalahan saat menambahkan produk');
                    }
                });
            });
        });

        // Fungsi untuk menampilkan waktu
        function updateTime() {
            const now = new Date();
            const day = String(now.getDate()).padStart(2, '0');
            const month = String(now.getMonth() + 1).padStart(2, '0'); // Bulan dimulai dari 0
            const year = now.getFullYear();
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            const seconds = String(now.getSeconds()).padStart(2, '0');

            // Format waktu menjadi dd-mm-yyyy HH:MM:SS
            const formattedTime = `${day}-${month}-${year} ${hours}:${minutes}:${seconds}`;

            // Menampilkan waktu pada elemen dengan id "current-time"
            document.getElementById('current-time').textContent = formattedTime;
        }

        // Memperbarui waktu setiap detik
        setInterval(updateTime, 1000); // 1000ms = 1 detik

        // Panggil fungsi pertama kali ketika halaman dimuat
        updateTime();
    </script>
@endsection
