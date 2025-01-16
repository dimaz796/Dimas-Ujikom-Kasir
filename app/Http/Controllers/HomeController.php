<?php

namespace App\Http\Controllers;

use App\Models\Penjualan;
use App\Models\Produk;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Ambil parameter pencarian
        $search = $request->input('search', '');

        // Query untuk mendapatkan produk, dengan filter pencarian berdasarkan nama
        $produk = Produk::where('nama_produk', 'like', "%{$search}%")
                        ->oldest()
                        ->paginate(10);

        // Menghitung jumlah transaksi untuk hari ini
        $currentDate = Carbon::now();
        $jumlahTransaksi = Penjualan::whereDate('tanggal_penjualan', $currentDate)->count() + 1;

        // Mengembalikan view dengan data produk yang sudah difilter
        return view('home.index', compact('produk', 'jumlahTransaksi'));
    }

}
