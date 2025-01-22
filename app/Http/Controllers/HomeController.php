<?php
namespace App\Http\Controllers;

use App\Models\Penjualan;
use App\Models\Produk;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search', '');

        $items = Produk::where('nama_produk', 'like', "%{$search}%")
                        ->oldest()
                        ->paginate(10);

        $keranjang = Session::get('keranjang', []);

        $currentDate = Carbon::now();
        $jumlahTransaksi = Penjualan::whereDate('tanggal_penjualan', $currentDate)->count() + 1;

        $produkIds = array_keys($keranjang);
        $produk = Produk::whereIn('produk_id', $produkIds)->get();

        foreach ($produk as $item) {
            if (isset($keranjang[$item->produk_id])) {
                $keranjang[$item->produk_id]['nama_produk'] = $item->nama_produk;
                $keranjang[$item->produk_id]['harga'] = $item->harga;
                $keranjang[$item->produk_id]['foto'] = $item->foto;
                $keranjang[$item->produk_id]['stok'] = $item->stok;
            }
        }
        return view('home.index', compact('items', 'jumlahTransaksi', 'keranjang', 'produk'));
    }

    public function tambahKeranjang(Request $request)
    {
        $produk_id = $request->input('produk_id');

        $keranjang = Session::get('keranjang', []);

        if (isset($keranjang[$produk_id])) {
            $keranjang[$produk_id]['jumlah'] += 1;
        } else {
            $produk = Produk::findOrFail($produk_id);
            $keranjang[$produk_id] = [
                'produk_id' => $produk->produk_id,
                'jumlah' => 1,
            ];
        }

        Session::put('keranjang', $keranjang);

        $produk = Produk::whereIn('produk_id', array_keys($keranjang))->get();

        return response()->json([
            'status' => 'success',
            'message' => 'Produk berhasil ditambahkan ke keranjang',
            'keranjang' => $produk,
        ]);

    }
}
