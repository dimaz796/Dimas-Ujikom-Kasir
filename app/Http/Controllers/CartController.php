<?php

namespace App\Http\Controllers;

use App\Models\Penjualan;
use App\Models\Produk;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{

    public function index()
    {

        $currentDate = Carbon::now();
        $jumlahTransaksi = Penjualan::whereDate('tanggal_penjualan', $currentDate)->count() + 1;

        $keranjang = Session::get('keranjang', []);


        $produkIds = array_keys($keranjang);


        $produk = Produk::whereIn('produk_id', $produkIds)->get();


        foreach ($produk as $item) {

            if (isset($keranjang[$item->produk_id])) {

                $keranjang[$item->produk_id]['nama_produk'] = $item->nama_produk;
                $keranjang[$item->produk_id]['harga'] = $item->harga;
                $keranjang[$item->produk_id]['stok'] = $item->stok;
                $keranjang[$item->produk_id]['foto'] = $item->foto;
            }
        }

        // Update session keranjang setelah ditambahkan data produk yang lengkap
        Session::put('keranjang', $keranjang);

        // Kirimkan data keranjang ke view
        return view('keranjang.index', compact('keranjang','jumlahTransaksi'));
    }

    public function updateKeranjang(Request $request)
    {
        $produkId = $request->input('produk_id');
        $jumlah = $request->input('jumlah');

        // Ambil keranjang yang ada di session
        $keranjang = Session::get('keranjang', []);

        // Jika produk ada di keranjang, update jumlahnya
        if (isset($keranjang[$produkId])) {
            $keranjang[$produkId]['jumlah'] = $jumlah;
        }

        // Simpan kembali keranjang yang sudah diperbarui ke session
        Session::put('keranjang', $keranjang);

        return response()->json([
            'status' => 'success',
            'message' => 'Keranjang berhasil diperbarui',
        ]);
    }

    public function hapusProduk(Request $request)
{
    $produkId = $request->input('produk_id');

    // Ambil keranjang dari session
    $keranjang = Session::get('keranjang', []);

    // Periksa apakah produk ada di keranjang
    if (isset($keranjang[$produkId])) {
        // Hapus produk dari keranjang
        unset($keranjang[$produkId]);

        // Simpan kembali keranjang yang sudah diperbarui ke session
        Session::put('keranjang', $keranjang);

        // Menghitung jumlah total produk dalam keranjang
        $jumlahKeranjang = count($keranjang);

        return response()->json([
            'status' => 'success',
            'message' => 'Produk berhasil dihapus dari keranjang',
            'jumlahKeranjang' => $jumlahKeranjang, // Kirim jumlah keranjang yang diperbarui
        ]);
    }

    // Jika produk tidak ditemukan di keranjang
    return response()->json([
        'status' => 'error',
        'message' => 'Produk tidak ditemukan di keranjang',
    ]);
}
}
