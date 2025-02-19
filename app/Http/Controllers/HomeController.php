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

        $items = Produk::where('status','active')
                    ->where('nama_produk', 'like', "%{$search}%")
            ->where('stok', '>=', 1)
            ->oldest()
            ->paginate(8);
        $keranjang = Session::get('keranjang', []);
        $jumlahKeranjang = count($keranjang);

        $produkIds = array_keys($keranjang);
        $produk = Produk::where('status','active')->whereIn('produk_id', $produkIds)->get();

        return view('home.index', compact('items', 'jumlahKeranjang', 'produk'));
    }

    public function tambahKeranjang(Request $request)
    {
        $produk_id = $request->input('produk_id');

        $produk = Produk::find($produk_id);

        if (!$produk) {
            return response()->json([
                'status' => 'error',
                'message' => 'Produk tidak ditemukan',
            ]);
        }

        if ($produk->stok < 1) {
            return response()->json([
                'status' => 'error',
                'message' => 'Stok habis',
            ]);
        }

        $keranjang = Session::get('keranjang', []);

        if (isset($keranjang[$produk_id])) {
            $jumlahDalamKeranjang = $keranjang[$produk_id]['jumlah'];

            if ($jumlahDalamKeranjang >= $produk->stok) {
                return response()->json([
                    'status' => 'info',
                    'message' => 'Produk ini sudah habis, sudah ada dalam keranjang kamu.',
                ]);
            }

            $keranjang[$produk_id]['jumlah'] += 1;
        } else {
            $keranjang[$produk_id] = [
                'produk_id' => $produk->produk_id,
                'jumlah' => 1,
            ];
        }

        Session::put('keranjang', $keranjang);

        $jumlahKeranjang = count($keranjang);
        $produk = Produk::whereIn('produk_id', array_keys($keranjang))->get();

        return response()->json([
            'status' => 'success',
            'message' => 'Produk berhasil ditambahkan ke keranjang',
            'keranjang' => $produk,
            'jumlahKeranjang' => $jumlahKeranjang,
        ]);
    }
}
