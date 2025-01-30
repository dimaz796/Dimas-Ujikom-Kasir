@extends('component.layout')

@section('title', 'Laporan Penjualan')

@section('content')

<div class="container mx-auto p-3">

    <div class="row">
        <div class="col-8">
            <div class="card">
                <div class="p-3">
                    <h2 class="text-2xl font-semibold mb-4">Laporan Transaksi Bulanan</h2>

                    <!-- Grafik Total Transaksi per Bulan -->
                    <canvas id="transaksiChart"></canvas>
                </div>
            </div>
        </div>

        <div class="col-4">
            <div class="card">
                <div class="p-3">
                    <h2 class="text-2xl font-semibold mt-10 mb-4">Detail Penjualan Terlaris</h2>

                    <!-- Tabel Detail Penjualan -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white border border-gray-300">
                            <thead>
                                <tr class="bg-gray-200">
                                    <th class="px-4 py-2 border">Produk</th>
                                    <th class="px-4 py-2 border">Jumlah Terjual</th>
                                    <th class="px-4 py-2 border">Total Harga</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($dataProdukTerjual as $detail)
                                <tr class="text-center">
                                    <td class="px-4 py-2 border">{{ $detail->produk->nama_produk }}</td>
                                    <td class="px-4 py-2 border">{{ $detail->total_jual }}</td>
                                    <td class="px-4 py-2 border">{{ number_format($detail->total_harga, 0, ',', '.') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
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
                borderColor: 'rgb(75, 192, 192)',
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
