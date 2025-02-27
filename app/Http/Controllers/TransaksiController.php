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

    public function index(Request $request)
    {
        $startDate = $request->input('start_date', null);
        $endDate = $request->input('end_date', null);

        if ($startDate && $endDate && $startDate > $endDate) {
            return back()->with('error', 'Tanggal Tidak Valid')->withInput();
        }

        $isDisabled = !($startDate || $endDate);

        $transaksiQuery = Penjualan::with(['pelanggan', 'user']);

        if ($startDate && !$endDate) {
            $transaksiQuery->whereDate('tanggal_penjualan', $startDate);
        } elseif (!$startDate && $endDate) {
            $transaksiQuery->whereDate('tanggal_penjualan', $endDate);
        } elseif ($startDate && $endDate) {
            $transaksiQuery->whereBetween('tanggal_penjualan', [$startDate, $endDate]);
        }

        if ($search = request('search')) {
            $transaksiQuery->where(function ($query) use ($search) {
                $query->where('penjualan_id', 'like', "%{$search}%")
                    ->orWhere('total_harga', 'like', "%{$search}%")
                    ->orWhereHas('pelanggan', function ($query) use ($search) {
                        $query->where('nama_pelanggan', 'like', "%{$search}%");
                    });
            });
        }

        $grandTotal = $transaksiQuery->sum('total_harga');

        // $transaksi = $transaksiQuery->paginate(10);
        $transaksi = $transaksiQuery->get();

        $firstTransactionYear = Penjualan::min(DB::raw('YEAR(tanggal_penjualan)'));

        $currentYear = now()->year;

        $distinctMonths = Penjualan::select(DB::raw('MONTH(tanggal_penjualan) as month'))
            ->distinct()
            ->orderBy(DB::raw('MONTH(tanggal_penjualan)'))
            ->pluck('month');

        $currentMonth = now()->month;

        return view('transaksi.index', compact(
            'transaksi',
            'grandTotal',
            'firstTransactionYear',
            'currentYear',
            'currentMonth',
            'distinctMonths',
            'startDate',
            'endDate',
            'isDisabled',
            'search'
        ));
    }



    public function laporan(Request $request)
    {
        $bulan = $request->input('bulan');
        $tahun = $request->input('tahun');

        $firstTransactionYear = Penjualan::min(DB::raw('YEAR(tanggal_penjualan)')) ?? now()->year;

        $startDate = Carbon::createFromFormat('Y-m', "{$tahun}-{$bulan}")->startOfMonth();
        $endDate = Carbon::createFromFormat('Y-m', "{$tahun}-{$bulan}")->endOfMonth();

        $dataTransaksi = Penjualan::whereBetween('tanggal_penjualan', [$startDate, $endDate])
            ->selectRaw('DATE(tanggal_penjualan) as date, sum(total_harga) as total_transaksi')
            ->groupBy('date')
            ->orderBy('date')
            ->get();


        $dataProdukTerjual = DetailPenjualan::with('produk')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('produk_id')
            ->selectRaw('produk_id, sum(jumlah_produk) as total_jual, sum(subtotal) as total_harga')
            ->orderByDesc('total_jual')
            ->get();

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

        return Excel::download(new ProdukTerjualExport($startDate, $endDate), 'Produk_Terjual_'.$bulan.'_'.$tahun.'.xlsx');
    }

    public function exportToPDF(Request $request)
    {
        $bulan = $request->input('bulan');
        $tahun = $request->input('tahun');
        $bulanNama = Carbon::createFromFormat('m', $bulan)->translatedFormat('F');

        $startDate = Carbon::createFromFormat('Y-m', "{$tahun}-{$bulan}")->startOfMonth();
        $endDate = Carbon::createFromFormat('Y-m', "{$tahun}-{$bulan}")->endOfMonth();

        $produkTerjual = DetailPenjualan::join('produk', 'detail_penjualans.produk_id', '=', 'produk.produk_id')
            ->whereBetween('detail_penjualans.created_at', [$startDate, $endDate])
            ->groupBy('detail_penjualans.produk_id', 'produk.nama_produk')
            ->selectRaw('detail_penjualans.produk_id, sum(jumlah_produk) as total_jual, sum(subtotal) as total_harga, produk.nama_produk as produk_nama')
            ->orderByDesc('total_jual')
            ->get();

        $grandTotal = $produkTerjual->sum('total_harga');

        $alamat = "Jalan TokTok No 12";
        $telephone = "(022) 12312341 ";
        $tanggal = Carbon::now()->translatedFormat('j F Y');

        $pdf = Pdf::loadView('transaksi.pdf_laporan', compact('produkTerjual', 'grandTotal', 'bulanNama', 'tahun','alamat','telephone','tanggal'));

        return $pdf->download('Produk_Terjual_'.$bulan.'_'.$tahun.'.pdf');
    }

    public function print(Request $request)
    {
        $bulan = $request->input('bulan');
        $tahun = $request->input('tahun');
        $bulanNama = Carbon::createFromFormat('m', $bulan)->translatedFormat('F');

        $startDate = Carbon::createFromFormat('Y-m', "{$tahun}-{$bulan}")->startOfMonth();
        $endDate = Carbon::createFromFormat('Y-m', "{$tahun}-{$bulan}")->endOfMonth();

        $produkTerjual = DetailPenjualan::join('produk', 'detail_penjualans.produk_id', '=', 'produk.produk_id')
            ->whereBetween('detail_penjualans.created_at', [$startDate, $endDate])
            ->groupBy('detail_penjualans.produk_id', 'produk.nama_produk')
            ->selectRaw('detail_penjualans.produk_id, sum(jumlah_produk) as total_jual, sum(subtotal) as total_harga, produk.nama_produk as produk_nama')
            ->orderByDesc('total_jual')
            ->get();

        $grandTotal = $produkTerjual->sum('total_harga');

        $alamat = "Jalan TokTok No 12";
        $telephone = "(022) 12312341 ";
        $tanggal = Carbon::now()->translatedFormat('j F Y');

        return view('transaksi.pdf_laporan', compact('produkTerjual', 'grandTotal', 'bulanNama', 'tahun', 'alamat', 'telephone', 'tanggal'));
    }


    public function printPDF(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $search = $request->input('search');

        $transaksiQuery = Penjualan::with(['pelanggan', 'user', 'detailPenjualan.produk']);

        if ($startDate) {
            $transaksiQuery->whereDate('tanggal_penjualan', '>=', $startDate);
        }

        if ($endDate) {
            $transaksiQuery->whereDate('tanggal_penjualan', '<=', $endDate);
        }

        if ($search) {
            $transaksiQuery->where(function ($query) use ($search) {
                $query->where('penjualan_id', 'like', "%{$search}%")
                      ->orWhereHas('pelanggan', function ($query) use ($search) {
                          $query->where('nama_pelanggan', 'like', "%{$search}%");
                      })
                      ->orWhereHas('detailPenjualan.produk', function ($query) use ($search) {
                          $query->where('nama_produk', 'like', "%{$search}%");
                      });
            });
        }

        $tanggal = Carbon::now()->translatedFormat('j F Y');

        $alamat = "Jalan TokTok No 12";
        $telephone = "(022) 12312341 ";

        $transaksi = $transaksiQuery->get();

        if ($startDate && $endDate) {
            $fileName = 'transaksi_penjualan_' . $startDate . '_sampai_' . $endDate . '.pdf';
        } elseif ($startDate) {
            $fileName = 'transaksi_penjualan_' . $startDate . '.pdf';
        } elseif ($endDate) {
            $fileName = 'transaksi_penjualan_' . $endDate . '.pdf';
        } else {
            $fileName = 'transaksi_penjualan.pdf';
        }

        $pdf = PDF::loadView('transaksi.laporan_penjualan_pdf', compact('transaksi', 'startDate', 'endDate','alamat','telephone','tanggal'));

        return $pdf->download($fileName);
    }

    public function riwayatTransaksi(Request $request)
    {
        $startDate = $request->input('start_date', null);
        $endDate = $request->input('end_date', null);
        $search = $request->input('search',null);

        if ($startDate && $endDate && $startDate > $endDate) {
            return back()->with('error', 'Tanggal Tidak Valid')->withInput();
        }

        $isDisabled = !(isset($startDate) && isset($endDate));


        $transaksiQuery = Penjualan::with(['pelanggan', 'user'])
        ->where('user_id', auth()->id());

        if ($startDate && !$endDate) {
            $transaksiQuery->whereDate('tanggal_penjualan', $startDate);
        } elseif (!$startDate && $endDate) {
            $transaksiQuery->whereDate('tanggal_penjualan', $endDate);
        } elseif ($startDate && $endDate) {
            $transaksiQuery->whereBetween('tanggal_penjualan', [$startDate, $endDate]);
        }

        if ($search = request('search')) {
            $transaksiQuery->where(function ($query) use ($search) {
                $query->where('penjualan_id', 'like', "%{$search}%")
                    ->orWhere('total_harga', 'like', "%{$search}%")
                    ->orWhereHas('pelanggan', function ($query) use ($search) {
                        $query->where('nama_pelanggan', 'like', "%{$search}%");
                    });
            });
        }

        $transaksi = $transaksiQuery->get();


        $grandTotal = $transaksi->sum('total_harga');


        return view('transaksi.riwayat_transaksi', compact('transaksi', 'startDate', 'endDate','isDisabled','grandTotal'));
    }
}
