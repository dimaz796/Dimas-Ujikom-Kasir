@extends('component.layout')

@section('title', 'Laporan Penjualan')

@section('content')
<style>
    @media print {
        /* Menyembunyikan elemen tombol cetak saat print */
        #print-controls {
            display: none;
        }

        /* Opsional: Menyembunyikan elemen-elemen lain yang tidak ingin dicetak */
        body * {
            visibility: hidden;
        }

        /* Menampilkan kembali konten yang ingin dicetak */
        .container, .container * {
            visibility: visible;
        }
        @page {
        margin: 0;
    }
    }
</style>

<div class="container mx-auto p-3">

    <div class="row">
        <div class="col-lg-8 col-md-12" id="print-controls">
            <div class="card">
                <div class="p-3">
                    <h2 class="text-2xl font-semibold mb-4">Laporan Transaksi : {{$namaBulan }} - {{ $selectedYear }}</h2>

                    <!-- Grafik Total Transaksi per Bulan -->
                    <canvas id="transaksiChart"></canvas>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-12" id="print-controls">
            <div class="row">
                <div class="col-lg-12 col-md-6">
                    <div class="card">
                        <div class="p-3">
                            <span class=" text-xl p-3 text-blue-500 fw-semibold">Total Pendapatan</span>
                            <h2 class="fw-bold text-xxl ps-3">Rp {{ number_format($totalSemuaTransaksi, 0, ',', '.') }}</h2>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 col-md-6">
                    <div class="card mt-3">
                        <div class="p-3">
                            <div class="row">
                                <div class="col-12">
                                    <span class=" p-3 text-2xl fw-semibold"> Cetak Laporan</span>
                                </div>
                                <div class="col-12">
                                    <div class="p-3">
                                        <a href="{{ route('laporan.print', ['bulan' => $selectedMonth, 'tahun' => $selectedYear]) }}"
                                            target="_blank"
                                            class="btn btn-primary w-full mb-2">
                                             <span class="font-semibold">Print</span>
                                         </a>
                                        <button class="btn btn-danger w-full mb-2" onclick="window.location.href='{{ route('transaksi.exportToPDF', ['bulan' => $selectedMonth, 'tahun' => $selectedYear]) }}'"><span class="font-semibold">PDF</span></button>
                                        <button class="btn btn-success w-full" onclick="window.location.href='{{ route('transaksi.exportToExcel', ['bulan' => $selectedMonth, 'tahun' => $selectedYear]) }}'"><span class="font-semibold">Excel</span></button>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12">
            <div class="card mt-3">
                <div class="p-3">
                    <h2 class="text-2xl font-semibold mt-2 mb-4">Detail Penjualan Terlaris Bulan {{$namaBulan }} Tahun {{ $selectedYear }}</h2>

                    <!-- Tabel Detail Penjualan -->
                    <div class="overflow-x-auto">
                        <table class="w-full bg-white border border-gray-300">
                            <thead>
                                <tr class="bg-gray-200 text-center">
                                    <th class="px-4 py-2 border ">No</th>
                                    <th class="px-4 py-2 border ">Produk</th>
                                    <th class="px-4 py-2 border ">Jumlah Terjual</th>
                                    <th class="px-4 py-2 border ">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($dataProdukTerjual as $detail)
                                    <tr class="text-center">
                                        <td class="px-4 py-2 border ">{{ $loop->iteration }}</td>
                                        <td class="px-4 py-2 border ">{{ $detail->produk->nama_produk }}</td>
                                        <td class="px-4 py-2 border ">{{ $detail->total_jual }}</td>
                                        <td class="px-4 py-2 border ">Rp. {{ number_format($detail->total_harga, 0, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr class="bg-gray-200 text-center">
                                    <td colspan="3"><span class="fw-bold">Grand Total</span></td>
                                    <td><span class="fw-bold"> Rp. {{ number_format($totalSemuaTransaksi, 0, ',', '.') }}</span></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    // Mendapatkan data dari controller menggunakan blade echo
    const labels = {!! json_encode($labels) !!};
    const totalTransaksi = {!! json_encode($totalTransaksi) !!};

    // Grafik Total Transaksi Bulanan
    const transaksiCtx = document.getElementById('transaksiChart').getContext('2d');

    // Membuat chart pertama kali
    const transaksiChart = new Chart(transaksiCtx, {
        type: 'line',
        data: {
            labels: labels,  // Label dari controller
            datasets: [{
                label: 'Total Transaksi',
                data: totalTransaksi,
                borderColor: '#3b82f6',
                fill: true
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                tooltip: {
                    mode: 'index',
                    intersect: false,
                },
            },
            scales: {
                x: {
                    title: {
                        display: true,
                        text: 'Tanggal'
                    }
                },
                y: {
                    title: {
                        display: true,
                        text: 'Total Transaksi'
                    },
                    beginAtZero: true
                }
            }
        }
    });

    // Fungsi untuk memuat grafik berdasarkan bulan yang dipilih
    function updateChartData(month) {
        // Mengambil data transaksi untuk bulan yang dipilih (misalnya melalui AJAX)
        fetch(`/laporan/penjualan/${month}`)
            .then(response => response.json())
            .then(data => {
                // Memperbarui data grafik dengan data terbaru
                updateChart(data);
            });
    }

    // Update data setiap kali bulan dipilih
    bulanSelect.addEventListener('change', function() {
        currentMonth = this.value;
        updateChartData(currentMonth);
    });

    // Fungsi untuk memperbarui chart
    function updateChart(data) {
        transaksiChart.data.labels = data.labels;
        transaksiChart.data.datasets[0].data = data.totalTransaksi;
        transaksiChart.update();
    }
});
</script>

@endsection
