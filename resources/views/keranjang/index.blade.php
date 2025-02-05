@extends('component.layout')

@section('title', 'Keranjang')

@section('content')
    <!-- Struk -->
    <div class="row">
        <div class="col-8">
            <div class="card">
                <!-- Nomor Transaksi -->
                <div class="p-2">
                    <h4 class="fw-bold text-blue-700">Samquik</h4>
                    <div class="fw-medium">Tanggal : <span id="current-time"></span></div>
                    <div class="fw-medium">Nomor : {{ $nomor_transaksi }}</div>
                    <hr>
                </div>

                <!-- Keranjang Pembelian -->
                <div class="p-2 max-h-[400px] overflow-y-auto overflow-x-hidden border-2 bg-gray-50" id="keranjang-list">
                    @forelse($keranjang as $item)
                        <div class="py-2" id="produk-{{ $item['produk_id'] }}">
                            <div class="flex items-center w-full space-x-2 py-1 border">

                                <!-- Produk dan Tombol -->
                                <div class="flex items-center w-full h-20">
                                    <div class="w-full">
                                        <div class="p-2">
                                            <div class="flex items-center w-full">
                                                <!-- Gambar Produk -->
                                                <div class="flex-none w-13">
                                                    <img src="{{ asset('storage/' . $item['foto']) }}" alt=""
                                                        class="rounded-full object-cover" style="width: 50px;height: 50px;">
                                                </div>

                                                <!-- Nama Produk dan Harga -->
                                                <div class="flex-none w-50 ml-2">
                                                    <div class="font-medium text-truncate whitespace-nowrap overflow-hidden "
                                                        style="max-width: 100%;">
                                                        {{ Str::words($item['nama_produk'], 10) }}
                                                    </div>
                                                    <div class="text-xs text-gray-500 w-full">
                                                        Rp. <span class="produk-harga"
                                                            id="harga-{{ $item['produk_id'] }}">{{ number_format($item['harga'], 0, ',', '.') }}</span>
                                                    </div>
                                                </div>

                                                <!-- Tombol +, - dan Jumlah Produk -->
                                                <div class="ml-auto flex items-center space-x-5">
                                                    <div class="w-30 pt-2 pl-1 pr-1 flex space-x-1">
                                                        <button type="button"
                                                            class="px-2 py-1 text-xs font-medium text-center text-white bg-blue-700 rounded-sm hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300"
                                                            data-id="{{ $item['produk_id'] }}"
                                                            data-stok="{{ $item['stok'] }}">-</button>
                                                        <span
                                                            class="w-12 px-2 py-1 text-xs font-medium text-center text-blue-700 bg-gray-300 rounded-sm hover:bg-gray-400 focus:ring-4 focus:outline-none focus:ring-blue-300 cursor-pointer">
                                                            {{ $item['jumlah'] }}
                                                        </span>
                                                        <button type="button"
                                                            class="px-2 py-1 text-xs font-medium text-center text-white bg-blue-700 rounded-sm hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300"
                                                            data-id="{{ $item['produk_id'] }}"
                                                            data-stok="{{ $item['stok'] }}">+</button>
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
                                            <span class="text-sm font-semibold total-harga"
                                                id="total-harga-{{ $item['produk_id'] }}">
                                                Rp. {{ number_format($item['subtotal']) }}
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Ikon Hapus -->
                                <div class="flex items-center justify-center w-1/12">
                                    <div class="bg-gray-50 w-full">
                                        <div class="px-2 py-3">
                                            <span class="text-center text-sm font-semibold text-red-900 delete-item cursor-pointer"
                                                data-id="{{ $item['produk_id'] }}">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                    stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                                </svg>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="card">
                            <div class="p-3">
                            <span>
                                Belum Ada Produk Yang Di Pesan, <a href="{{ route('home') }}" class="no-underline fw-medium">Pesan Sekarang</a>
                            </span>
                        </div>
                        </div>
                    @endforelse
                </div>
                @if(count($keranjang) > 0)
                    <div class="flex justify-center">
                        <a href="{{ route('home') }}" class="no-underline fw-medium p-2">Tambah Pesanan </a>
                    </div>
                @endif
            </div>
        </div>
        <div class="col-4">
            <!-- Data Pelanggan -->
            <div class="px-2">
                <div class="bg-gray-50 border-2 p-2">
                    <form action="{{ route('keranjang.pembayaran') }}" method="POST">
                        @csrf
                        <div class="fw-semibold">Data Pelanggan</div>
                        <div class="py-1">
                            <input type="text" class="form-control" placeholder="Nama Pelanggan" name="nama_pelanggan"
                                required>
                        </div>
                        <div class="py-1">
                            <input type="text" class="form-control" placeholder="Alamat" name="alamat_pelanggan"
                                required>
                        </div>
                        <div class="py-1">
                            <input type="number" class="form-control" placeholder="No Telephon" name="nomor_telepon"
                                required>
                        </div>
                        <div class="flex items-center justify-between p-1">
                            <div class="flex-initial">
                                <button class="btn btn-primary" {{ $keranjang ? '' : 'disabled'  }}>Bayar Sekarang</button>
                            </div>
                            <div class="flex items-center">
                                <!-- Total Harga Keranjang -->
                                <div class="flex items-center fw-medium">
                                    Total : <span id="total-keranjang" class="ml-2">Rp.
                                        {{ number_format($totalKeranjang) }}</span>
                                </div>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {

            $('button[data-id][data-stok]').on('click', function() {
                var produkId = $(this).data('id');
                var stok = $(this).data('stok');
                var jumlahElement = $(this).siblings('span');
                var hargaElement = $(this).closest('.py-2').find(
                    '.text-xs.text-gray-500');
                var jumlah = parseInt(jumlahElement.text());
                var harga = parseInt(hargaElement.text().replace('Rp. ', '').replace(/\./g, '')
                    .trim());

                if ($(this).text() === '-') {
                    if (jumlah > 1) {
                        jumlahElement.text(jumlah - 1);
                        updateKeranjang(produkId, jumlah - 1);
                        updateSubtotal(produkId, jumlah - 1, harga);
                    }
                }

                if ($(this).text() === '+') {
                    if (jumlah < stok) {
                        jumlahElement.text(jumlah + 1);
                        updateKeranjang(produkId, jumlah + 1);
                        updateSubtotal(produkId, jumlah + 1, harga);
                    } else {
                        alert('Stok produk telah habis!');
                    }
                }
            });

            function updateSubtotal(produkId, jumlah, harga) {
                var subtotal = harga * jumlah;

                console.log(subtotal, harga, jumlah);

                // Memperbarui subtotal untuk produk yang relevan
                $('#total-harga-' + produkId).text('Rp. ' + number_format(subtotal));

                // Kirim data subtotal ke server menggunakan AJAX
                $.ajax({
                    url: '{{ route('keranjang.update') }}', // Ganti dengan route yang sesuai
                    method: 'POST',
                    data: {
                        produk_id: produkId,
                        jumlah: jumlah,
                        subtotal: subtotal,
                        _token: '{{ csrf_token() }}' // Jangan lupa untuk CSRF token
                    },
                    success: function(response) {
                        if (response.status == 'success') {
                            console.log('Subtotal berhasil diperbarui di session');
                        }
                    },
                    error: function() {
                        alert('Terjadi kesalahan saat memperbarui subtotal');
                    }
                });

                updateTotal();
            }

            function updateTotal() {
                var totalHarga = 0;

                $('.total-harga').each(function() {
                    var hargaItem = $(this).text().replace('Rp. ', '').replace(/\./g, '').replace(/,/g, '')
                        .trim();

                    totalHarga += parseInt(hargaItem);

                });

                $('#total-keranjang').text('Rp. ' + number_format(totalHarga));

            }


            // Hapus
            $('.delete-item').on('click', function() {
                var produkId = $(this).data('id');

                if (confirm('Apakah Anda yakin ingin menghapus produk ini dari keranjang?')) {
                    $.ajax({
                        url: '{{ route('keranjang.hapus') }}',
                        method: 'POST',
                        data: {
                            produk_id: produkId,
                            _token: '{{ csrf_token() }}',
                        },
                        success: function(response) {
                            if (response.status == 'success') {
                                alert('Produk berhasil dihapus dari keranjang');
                                $('#produk-' + produkId)
                                    .remove();
                                updateTotal();
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

            // memperbarui keranjang
            function updateKeranjang(produkId, jumlah) {
                $.ajax({
                    url: '{{ route('keranjang.update') }}',
                    method: 'POST',
                    data: {
                        produk_id: produkId,
                        jumlah: jumlah,
                        _token: '{{ csrf_token() }}',
                    },
                    success: function(response) {
                        if (response.status == 'success') {
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

            function number_format(number) {
                return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
            }
            setInterval(function() {
                const now = new Date();
                const optionsTime = { hour: '2-digit', minute: '2-digit' };
                const formattedTime = now.toLocaleTimeString('id-ID', optionsTime).replace(":", ".");

                const optionsDate = { day: 'numeric', month: 'long', year: 'numeric' };
                const formattedDate = now.toLocaleDateString('id-ID', optionsDate);

                // Gabungkan waktu dan tanggal
                const fullFormattedTime = `${formattedTime} ${formattedDate}`;
                document.getElementById('current-time').textContent = fullFormattedTime;
            }, 1000);
        });
    </script>
@endsection
