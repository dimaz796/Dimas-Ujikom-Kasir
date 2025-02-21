@extends('component.layout')

@section('title', 'Struk')

@section('content')

    <style>
        @media print {
            @page {
                margin: 0;
            }
            body {
                margin: 0;
                padding: 0;
                background: white;
            }
            body * {
                visibility: hidden;
            }
            #struk-belanja, #struk-belanja * {
                visibility: visible;
            }
            #struk-belanja {
                position: absolute;
                left: 12%;
                width: auto;
                max-width: 80%;
                box-shadow: none;
            }
            .no-print {
                display: none;
            }
        }
    </style>
    <div class="container mx-auto p-4">
        <!-- Card Utama -->
        <section class="dark:bg-gray-900 p-3 sm:p-5 flex justify-center">
            <div id="struk-belanja" class="bg-white p-6 rounded-lg shadow-md w-full max-w-lg border border-gray-300">
                <h1 class="text-xl text-center font-bold">Samquik</h1>
                <p class="text-sm text-center text-gray-700">Jl. TokTok</p>
                <p class="text-sm text-center text-gray-700">Telepon: 0821313</p>
                <div style="
                    border-top: 1px solid black;
                    margin: 10px 0;
                "></div>

                <div class="text-sm flex justify-between">
                    <div class="flex flex-col">

                        <p><strong>Transaksi:</strong> {{ $penjualan->penjualan_id }}</p>
                        <p><strong>Tanggal:</strong> {{ $penjualan->tanggal_penjualan }}</p>
                        <p><strong>Kasir:</strong> {{ $penjualan->user->name }}</p>
                    </div>
                    <div class="">
                        @if ($penjualan->pelanggan)
                        <p><strong>Nama:</strong> {{ $penjualan->pelanggan->nama_pelanggan }}</p>
                        <p><strong>Alamat:</strong> {{ $penjualan->pelanggan->alamat_pelanggan }}</p>
                        <p><strong>Telepon:</strong> {{ $penjualan->pelanggan->nomor_telepon }}</p>
                    @endif
                    </div>
                </div>

                <div style="
                    border-top: 1px solid black;
                    margin: 10px 0;
                "></div>

                <table class="w-full text-sm font-sans">
                    <thead>
                        <tr>
                            <th class="text-left">Produk</th>
                            <th class="text-right">Harga</th>
                            <th class="text-right">Jumlah</th>
                            <th class="text-right">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($penjualan->detailPenjualan as $detail)
                            @php
                                $hargaSatuan = $detail->jumlah_produk > 0 ? ($detail->subtotal / $detail->jumlah_produk) : 0;
                            @endphp
                            <tr>
                                <td class="text-left">{{ $detail->produk?->nama_produk ?? $detail->nama_produk . " (Tidak tersedia)" }}</td>
                                <td class="text-right text-nowrap">Rp.{{ number_format($hargaSatuan) }}</td>
                                <td class="text-right">{{ $detail->jumlah_produk }}</td>
                                <td class="text-right">Rp.{{ number_format($detail->subtotal) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="4">
                                <hr class="my-2 border-dashed border-gray-400">
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" class="text-right font-bold">Total</td>
                            <td class="text-right font-bold">Rp.{{ number_format($penjualan->total_harga) }}</td>
                        </tr>
                        <tr>
                            <td colspan="3" class="text-right font-bold">Nominal Bayar</td>
                            <td class="text-right font-bold">Rp.{{ number_format($penjualan->nominal_pembayaran) }}</td>
                        </tr>
                        <tr>
                            <td colspan="3" class="text-right font-bold">Kembalian</td>
                            <td class="text-right font-bold">Rp.{{ number_format($penjualan->kembalian) }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </section>



        <div class="text-center mt-4">
            @if (auth()->user()->role === 'petugas')
                <button onclick="printStruk()" class="inline-block bg-gray-700 text-white px-4 py-2 rounded-lg text-sm hover:bg-gray-800">Cetak</button>
            @endif
            <a href="{{ route('home') }}" class="inline-block bg-blue-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-700">Kembali</a>
        </div>

    <script>
        function printStruk() {
            let printArea = document.getElementById('struk-belanja');

            if (!printArea) {
                alert("Struk tidak ditemukan!");
                return;
            }

            let originalContent = document.body.innerHTML;
            let printContent = printArea.innerHTML;

            document.body.innerHTML = printContent;
            window.print();
            document.body.innerHTML = originalContent;
            location.reload();
        }
    </script>
@endsection
