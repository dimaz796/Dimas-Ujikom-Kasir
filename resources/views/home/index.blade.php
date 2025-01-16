@extends('component.layout')

@section('title','Beranda')

@section('content')

<div class="card">
    <div class="p-3">

        <!-- Search Bar -->
        <form class="flex items-start max-w-sm ">   
            <label for="simple-search" class="sr-only">Search</label>
            <div class="relative w-full">
                <input type="text" id="simple-search" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="Cari Produk" required />
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
                <div class="row">
                    @forelse($produk as $item)
                    <div class="col-4 pt-3">
                    <div class="card shadow-lg d-flex flex-column">
                    <img src="{{ asset('storage/' . $item->foto) }}" alt="" class="card-img-top w-full" style="height: 150px; object-fit: cover;">
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
                                <button class="btn btn-primary w-full"><small>Tambah</small></button>
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
                    <div class="p-2">
                      <h4 class="fw-semibold text-blue-700">Samquik</h4>
                      <p>Tanggal: <span id="current-time"></span></p>

                    </div>
                </div>
            </div>
            
        </div>
    </div>
</div>

<script>
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