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
                        <input type="hidden" id="keterangan" name="keterangan" value="member">


                        <!-- Switch Member/Non-Member -->
                        <div class="form-check form-switch py-1">
                            <input class="form-check-input" checked type="checkbox" id="isMemberSwitch">
                            <label class="form-check-label" for="isMemberSwitch">Member</label>
                        </div>

                        <!-- Form untuk Non-Member -->
                        <div id="nonMemberFields" class="hidden">
                            <div class="py-1">
                                <input type="text" class="form-control" placeholder="Nama Pelanggan" name="nama_pelanggan" id="nama_pelanggan" oninput="checkFields()">
                            </div>
                            <div class="py-1">
                                <input type="text" class="form-control" placeholder="Alamat" name="alamat_pelanggan" id="alamat_pelanggan" oninput="checkFields()">
                            </div>
                            <div class="py-1">
                                <input type="number" class="form-control" placeholder="No Telepon" name="nomor_telepon" id="nomor_telepon" oninput="checkFields()">
                            </div>
                        </div>


                        <!-- Form untuk Member -->
                        <div id="memberFields">
                            <div class="row g-2 align-items-center">
                                <div class="col-9">
                                    <div class="input-group">
                                        <span class="input-group-text">SQ</span>
                                        <input type="text" class="form-control" id="pelanggan_id" name="pelanggan_id"
                                            placeholder="Masukkan Nomor" value="{{ old('pelanggan_id') }}" maxlength="3">
                                    </div>
                                </div>

                                <div class="col-3"> <!-- 25% dari 12 kolom -->
                                    <button type="button" class="btn btn-secondary w-100" id="verifyMember">Cari</button>
                                </div>
                                @error('pelanggan_id')
                                    <div class="col-12">
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    </div>
                                @enderror
                            </div>


                            <div id="memberData" class="hidden">
                                <div class="py-1">
                                    <input type="text" class="form-control" id="nama_pelanggan_member" name="nama_pelanggan_member" placeholder="Nama Pelanggan" readonly>
                                </div>
                                <div class="py-1">
                                    <input type="text" class="form-control" id="alamat_pelanggan_member" name="alamat_pelanggan_member" placeholder="Alamat" readonly>
                                </div>
                                <div class="py-1">
                                    <input type="number" class="form-control" id="nomor_telepon_member" name="nomor_telepon_member" placeholder="No Telepon" readonly>
                                </div>
                            </div>
                        </div>


                        <div class="py-1">
                            <span class="font-semibold">Masukan Nominal</span>
                            <input type="number" class="form-control" placeholder="Nominal Pembayaran" name="nominal_pembayaran" required value="{{ old('nominal_pembayaran') }}">
                        </div>
                        @if (session('error'))
                            <div class="text-red-600">
                                {{ session('error') }}
                            </div>
                        @endif

                        <div class="flex items-center justify-between p-1">
                            <div class="flex-initial">
                                <button class="btn btn-primary" {{ $keranjang ? '' : 'disabled' }}>Bayar Sekarang</button>
                            </div>
                            <div class="flex items-center">
                                <!-- Total Harga Keranjang -->
                                <div class="flex items-center fw-medium">
                                    Total : <span id="total-keranjang" class="ml-2">Rp. {{ number_format($totalKeranjang) }}</span>
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

            function checkFields() {
                let nama = document.getElementById("nama_pelanggan").value.trim();
                let alamat = document.getElementById("alamat_pelanggan").value.trim();
                let telepon = document.getElementById("nomor_telepon").value.trim();

                let isAnyFilled = nama !== "" || alamat !== "" || telepon !== "";

                document.getElementById("nama_pelanggan").required = isAnyFilled;
                document.getElementById("alamat_pelanggan").required = isAnyFilled;
                document.getElementById("nomor_telepon").required = isAnyFilled;
            }

            document.getElementById("nama_pelanggan").oninput = checkFields;
            document.getElementById("alamat_pelanggan").oninput = checkFields;
            document.getElementById("nomor_telepon").oninput = checkFields;


            function ensureSQPrefix(input) {
                if (!input.value.startsWith("SQ")) {
                    input.value = "SQ";
                }
            }

            const isMemberSwitch = document.getElementById("isMemberSwitch");
            const memberFields = document.getElementById("memberFields");
            const nonMemberFields = document.getElementById("nonMemberFields");
            const verifyMemberBtn = document.getElementById("verifyMember");
            const memberData = document.getElementById("memberData");
            const keteranganInput = document.getElementById("keterangan");

            function toggleFields() {
                if (isMemberSwitch.checked) {
                    memberFields.style.display = "block";
                    nonMemberFields.style.display = "none";
                    keteranganInput.value = "member";
                } else {
                    memberFields.style.display = "none";
                    nonMemberFields.style.display = "block";
                    keteranganInput.value = "non_member";
                }
            }

            isMemberSwitch.addEventListener("change", function () {
                toggleFields();
                if (this.checked) {
                    memberFields.classList.remove("hidden");
                    nonMemberFields.classList.add("hidden");

                } else {
                    memberFields.classList.add("hidden");
                    nonMemberFields.classList.remove("hidden");
                }
            });

            verifyMemberBtn.addEventListener("click", function () {
                pelangganKode = document.getElementById("pelanggan_id").value;

                const pelangganId = 'SQ' + pelangganKode;

                if (!pelangganId) {
                    alert("Masukkan ID Pelanggan terlebih dahulu! " + pelangganId);
                    return;
                }

                fetch(`/cari-pelanggan/${pelangganId}`)
                    .then(response => response.json())
                    .then(data => {
                        console.log(data);
                        
                        if (data.success) {
                            document.getElementById("nama_pelanggan_member").value = data.pelanggan.nama_pelanggan;
                            document.getElementById("alamat_pelanggan_member").value = data.pelanggan.alamat_pelanggan;
                            document.getElementById("nomor_telepon_member").value = data.pelanggan.nomor_telepon;

                            memberData.classList.remove("hidden");
                        } else {
                            alert("Pelanggan tidak ditemukan!" + pelangganId);
                        }
                    })
                    .catch(error => console.error("Terjadi kesalahan:", error));
                });
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
