@extends('component.layout')

@section('title','Beranda')

@section('content')
   <!-- Struk -->
            <div class="row">
                <div class="col-8">
                    <div class="card">
                        <!-- Nomor Transaksi -->
                        <div class="p-2">
                          <h4 class="fw-semibold text-blue-700">Samquik</h4>
                          <div>Tanggal : <span id="current-time"></span></div>
                          <div >Nomor : {{ $jumlahTransaksi }}</div>
                            <hr>
                        </div>

                        <!-- Keranjang Pembelian -->
                        <div class="p-2 max-h-[400px] overflow-y-auto overflow-x-hidden border-2 bg-gray-50" id="keranjang-list">
                            @forelse($keranjang as $item)
                            <div class=" py-2">
                            <div class="flex items-center w-full space-x-2 py-1 border">

                                <!-- Produk dan Tombol -->
                                <div class="flex items-center w-full h-20">
                                    <div class="  w-full">
                                        <div class="p-2">
                                            <div class="flex items-center w-full">
                                                <!-- Gambar Produk -->
                                                <div class="flex-none w-13">
                                                    <img src="{{ asset('storage/' . $item['foto']) }}" alt="" class="rounded-full object-cover" style="width: 50px;height: 50px;">
                                                </div>

                                                <!-- Nama Produk dan Harga -->
                                                <div class="flex-none w-50 ml-2">
                                                    <div class="font-medium text-truncate whitespace-nowrap overflow-hidden " style="max-width: 100%;">
                                                        {{ Str::words($item['nama_produk'], 10) }}
                                                    </div>
                                                    <div class="text-xs text-gray-500 w-full">Rp. {{ number_format($item['harga']) }}</div>
                                                </div>

                                                <!-- Tombol +, - dan Jumlah Produk -->
                                                <div class="ml-auto flex items-center space-x-5">
                                                    <div class="w-30 pt-2 pl-1 pr-1 flex space-x-1">
                                                        <button type="button" class="px-2 py-1 text-xs font-medium text-center text-white bg-blue-700 rounded-sm hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300" data-id="{{ $item['produk_id'] }}" data-stok="{{ $item['stok'] }}">-</button>
                                                        <span class="w-12 px-2 py-1 text-xs font-medium text-center text-blue-700 bg-gray-300 rounded-sm hover:bg-gray-400 focus:ring-4 focus:outline-none focus:ring-blue-300 cursor-pointer">
                                                            {{ $item['jumlah'] }}
                                                        </span>
                                                        <button type="button" class="px-2 py-1 text-xs font-medium text-center text-white bg-blue-700 rounded-sm hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300" data-id="{{ $item['produk_id'] }}" data-stok="{{ $item['stok'] }}">+</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Total Harga -->
                                <div class="flex items-center w-1/4">
                                    <div class="bg-gray-50 w-full h-full">
                                        <div class="px-2 py-3 w-36">
                                            <span class="text-sm font-semibold">Rp. {{ number_format($item['harga'] * $item['jumlah']) }}</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Ikon Hapus -->
                                <div class="flex items-center justify-center w-1/12">
                                    <div class="bg-gray-50 w-full">
                                        <div class="px-2 py-3">
                                            <span class="text-center text-sm font-semibold text-red-900 delete-item" data-id="{{ $item['produk_id'] }}">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                                </svg>
                                            </span>

                                        </div>
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



                    </div>
                </div>
                <div class="col-4">
                    <!-- Data Pelanggan -->
                    <div class="px-2">
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
         $(document).ready(function() {
        // Menangani klik pada tombol minus
        $('button[data-id][data-stok]').on('click', function() {
            var produkId = $(this).data('id');  // Mendapatkan produk_id
            var stok = $(this).data('stok');  // Mendapatkan stok produk
            var jumlahElement = $(this).siblings('span');  // Mendapatkan elemen span jumlah
            var jumlah = parseInt(jumlahElement.text());  // Mendapatkan jumlah produk yang ada

            // Jika tombol yang diklik adalah tombol minus
            if ($(this).text() === '-') {
                if (jumlah > 1) {
                    // Mengurangi jumlah produk
                    jumlahElement.text(jumlah - 1);
                    updateKeranjang(produkId, jumlah - 1);
                }
            }

            // Jika tombol yang diklik adalah tombol plus
            if ($(this).text() === '+') {
                if (jumlah < stok) {
                    // Menambah jumlah produk
                    jumlahElement.text(jumlah + 1);
                    updateKeranjang(produkId, jumlah + 1);
                } else {
                    // Jika jumlah melebihi stok
                    alert('Stok produk telah habis!');
                }
            }
        });

        $(document).ready(function() {
        // Event listener untuk klik ikon hapus
        $('.delete-item').on('click', function() {
            var produkId = $(this).data('id'); // Mendapatkan produk_id dari data-id

            // Konfirmasi penghapusan
            if (confirm('Apakah Anda yakin ingin menghapus produk ini dari keranjang?')) {
                // Kirim permintaan AJAX untuk menghapus produk dari keranjang
                $.ajax({
                    url: '{{ route('keranjang.hapus') }}', // Ganti dengan route yang sesuai untuk menghapus produk dari keranjang
                    method: 'POST',
                    data: {
                        produk_id: produkId,
                        _token: '{{ csrf_token() }}',  // Jangan lupa menyertakan CSRF token
                    },
                    success: function(response) {
                        if (response.status == 'success') {
                            // Jika penghapusan berhasil, perbarui keranjang di UI
                            alert('Produk berhasil dihapus dari keranjang');
                            // Kamu bisa memperbarui UI keranjang di sini, misalnya menghapus elemen produk dari tampilan
                            $('#produk-' + produkId).remove(); // Misalnya menghapus elemen dengan id produk yang sesuai
                            $('#jumlah-keranjang').text(response.jumlahKeranjang); // Update jumlah keranjang
                        } else {
                            alert('Terjadi kesalahan saat menghapus produk');
                        }
                    },
                    error: function() {
                        alert('Terjadi kesalahan saat menghapus produk');
                    }
                });
            }
        });
    });

        // Fungsi untuk mengupdate keranjang ke server menggunakan AJAX
        function updateKeranjang(produkId, jumlah) {
            $.ajax({
                url: '{{ route('keranjang.update') }}',  // Ganti dengan route yang sesuai untuk update keranjang
                method: 'POST',
                data: {
                    produk_id: produkId,
                    jumlah: jumlah,
                    _token: '{{ csrf_token() }}',  // Jangan lupa menyertakan CSRF token
                },
                success: function(response) {
                    if (response.status == 'success') {
                        // Update keranjang di UI jika diperlukan
                        console.log('Keranjang diperbarui');
                    } else {
                        alert('Terjadi kesalahan saat memperbarui keranjang');
                    }
                },
                error: function() {
                    alert('Terjadi kesalahan saat memperbarui keranjang');
                }
            });
        }
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
