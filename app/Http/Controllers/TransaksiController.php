<?php

namespace App\Http\Controllers;

use App\Exports\ProdukTerjualExport;
use App\Models\DetailPenjualan;
use App\Models\Penjualan;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class TransaksiController extends Controller
{

    public function index()
    {
        $transaksi = Penjualan::with(['pelanggan','user'])->get();

        $firstTransactionYear = Penjualan::min(DB::raw('YEAR(tanggal_penjualan)'));

        $currentYear = now()->year;

        $distinctMonths = Penjualan::select(DB::raw('MONTH(tanggal_penjualan) as month'))
        ->distinct()
        ->orderBy(DB::raw('MONTH(tanggal_penjualan)'))
        ->pluck('month');


    $currentMonth = now()->month;

    // Pass the variables to the view
    return view('transaksi.index', compact('transaksi', 'firstTransactionYear', 'currentYear', 'currentMonth', 'distinctMonths'));
    }

    public function laporan(Request $request)
    {
        $bulan = $request->input('bulan');
        $tahun = $request->input('tahun');

        $firstTransactionYear = Penjualan::min(DB::raw('YEAR(tanggal_penjualan)')) ?? now()->year;

        $startDate = Carbon::createFromFormat('Y-m', "{$tahun}-{$bulan}")->startOfMonth();
        $endDate = Carbon::createFromFormat('Y-m', "{$tahun}-{$bulan}")->endOfMonth();

        // Ambil data transaksi berdasarkan tanggal
        $dataTransaksi = Penjualan::whereBetween('tanggal_penjualan', [$startDate, $endDate])
            ->selectRaw('DATE(tanggal_penjualan) as date, sum(total_harga) as total_transaksi')
            ->groupBy('date')
            ->orderBy('date')
            ->get();


        // Ambil produk terlaris
        $dataProdukTerjual = DetailPenjualan::with('produk')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('produk_id')
            ->selectRaw('produk_id, sum(jumlah_produk) as total_jual, sum(subtotal) as total_harga')
            ->orderByDesc('total_jual')
            ->get();

        // Format data untuk frontend
        $labels = $dataTransaksi->pluck('date')->toArray();
        $totalTransaksi = $dataTransaksi->pluck('total_transaksi')->toArray();

        $totalSemuaTransaksi = $dataTransaksi->sum('total_transaksi');

        $bulanNama = Carbon::createFromFormat('m', $bulan)->locale('id')->isoFormat('MMMM');


        return view('transaksi.laporan', [
            'labels' => $labels,
            'totalTransaksi' => $totalTransaksi,
            'dataProdukTerjual' => $dataProdukTerjual,
            'selectedMonth' => $bulan,
            'selectedYear' => $tahun,
            'firstTransactionYear' => $firstTransactionYear,
            'totalSemuaTransaksi' => $totalSemuaTransaksi,
            'namaBulan' => $bulanNama,
        ]);
    }


    public function exportToExcel(Request $request)
    {
        $bulan = $request->input('bulan');
        $tahun = $request->input('tahun');

        $startDate = Carbon::createFromFormat('Y-m', "{$tahun}-{$bulan}")->startOfMonth();
        $endDate = Carbon::createFromFormat('Y-m', "{$tahun}-{$bulan}")->endOfMonth();

        // Mengembalikan file Excel
        return Excel::download(new ProdukTerjualExport($startDate, $endDate), 'Produk_Terjual_'.$bulan.'_'.$tahun.'.xlsx');
    }

    public function exportToPDF(Request $request)
    {
        $bulan = $request->input('bulan');
        $tahun = $request->input('tahun');

        $startDate = Carbon::createFromFormat('Y-m', "{$tahun}-{$bulan}")->startOfMonth();
        $endDate = Carbon::createFromFormat('Y-m', "{$tahun}-{$bulan}")->endOfMonth();

        // Ambil data sesuai filter bulan dan tahun
        $dataProdukTerjual = // Ambil data produk terjual dari database
        $totalSemuaTransaksi = // Hitung total semua transaksi

        // Membuat PDF
        $pdf = Pdf::loadView('pdf.penjualan', compact('dataProdukTerjual', 'totalSemuaTransaksi', 'bulan', 'tahun'));

        return $pdf->download('Produk_Terjual_'.$bulan.'_'.$tahun.'.pdf');
    }




}
