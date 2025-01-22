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
        $jumlahKeranjang = count($keranjang);

        $produkIds = array_keys($keranjang);
        $produk = Produk::whereIn('produk_id', $produkIds)->get();

        return view('home.index', compact('items', 'jumlahKeranjang', 'produk'));
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

        $jumlahKeranjang = count($keranjang);  // Menghitung jumlah produk di keranjang
        $produk = Produk::whereIn('produk_id', array_keys($keranjang))->get();

        return response()->json([
            'status' => 'success',
            'message' => 'Produk berhasil ditambahkan ke keranjang',
            'keranjang' => $produk,
            'jumlahKeranjang' => $jumlahKeranjang,  // Mengirimkan jumlah keranjang yang terbaru
        ]);
    }

}
