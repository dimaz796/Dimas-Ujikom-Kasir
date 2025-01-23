<?php

namespace App\Http\Controllers;

use App\Models\DetailPenjualan;
use App\Models\Pelanggan;
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

        $totalKeranjang = 0;


        foreach ($produk as $item) {

            if (isset($keranjang[$item->produk_id])) {

                $keranjang[$item->produk_id]['nama_produk'] = $item->nama_produk;
                $keranjang[$item->produk_id]['harga'] = $item->harga;
                $keranjang[$item->produk_id]['stok'] = $item->stok;
                $keranjang[$item->produk_id]['foto'] = $item->foto;

                $subtotal = $item->harga * $keranjang[$item->produk_id]['jumlah'];
                $keranjang[$item->produk_id]['subtotal'] = $subtotal;

                $totalKeranjang += $subtotal;
            }
        }

<<<<<<< HEAD
        Session::put('keranjang', $keranjang);

=======

        // Update session keranjang setelah ditambahkan data produk yang lengkap
        Session::put('keranjang', $keranjang);

        // Kirimkan data keranjang ke view
>>>>>>> d69980d7bc03db9fb85d1c0efc33f79291e24f26
        return view('keranjang.index', compact('keranjang', 'jumlahTransaksi', 'totalKeranjang'));
    }

    public function updateKeranjang(Request $request)
    {
        // Ambil data dari request
        $produkId = $request->input('produk_id');
        $subtotal = $request->input('subtotal');
        $jumlah = $request->input('jumlah');
<<<<<<< HEAD
        $harga = $request->input('harga');

        $keranjang = Session::get('keranjang', []);

=======
        $harga = $request->input('harga');  // Pastikan harga juga dikirim

        // Hitung subtotal untuk produk ini (harga * jumlah)
        $subtotal = $harga * $jumlah;

        // Ambil keranjang dari session atau buat array kosong jika tidak ada
        $keranjang = Session::get('keranjang', []);

        // Jika produk sudah ada dalam keranjang, update jumlah dan subtotalnya
>>>>>>> d69980d7bc03db9fb85d1c0efc33f79291e24f26
        if (isset($keranjang[$produkId])) {
            // Update jumlah produk dan subtotal baru
            $keranjang[$produkId]['jumlah'] = $jumlah;
<<<<<<< HEAD
            $keranjang[$produkId]['subtotal'] = $subtotal;
        } else {
=======
            $keranjang[$produkId]['subtotal'] = $subtotal; // Simpan subtotal di session
        } else {
            // Jika produk belum ada, tambahkan produk baru beserta subtotalnya
>>>>>>> d69980d7bc03db9fb85d1c0efc33f79291e24f26
            $keranjang[$produkId] = [
                'produk_id' => $produkId,
                'jumlah' => $jumlah,
                'harga' => $harga,
<<<<<<< HEAD
                'subtotal' => $subtotal,
            ];
        }

        Session::put('keranjang', $keranjang);

=======
                'subtotal' => $subtotal,  // Simpan subtotal di session
            ];
        }

        // Simpan kembali keranjang yang telah diperbarui ke dalam session
        Session::put('keranjang', $keranjang);

        // Mengembalikan response success
>>>>>>> d69980d7bc03db9fb85d1c0efc33f79291e24f26
        return response()->json(['status' => 'success']);
    }

    public function hapusProduk(Request $request)
    {
        $produkId = $request->input('produk_id');

<<<<<<< HEAD
        $keranjang = Session::get('keranjang', []);

        if (isset($keranjang[$produkId])) {

            unset($keranjang[$produkId]);
            Session::put('keranjang', $keranjang);

            $jumlahKeranjang = count($keranjang);

            return response()->json([
                'status' => 'success',
                'message' => 'Produk berhasil dihapus dari keranjang',
                'jumlahKeranjang' => $jumlahKeranjang,
            ]);
        }
=======
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
>>>>>>> d69980d7bc03db9fb85d1c0efc33f79291e24f26

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
<<<<<<< HEAD

    public function struk(Request $request)
    {
        $penjualan_id = $request->input('id_penjualan');

        $penjualan = Penjualan::with(['pelanggan', 'detailPenjualan.produk'])
            ->where('penjualan_id', $penjualan_id)
            ->first();

        if (!$penjualan) {
            return redirect()->back()->withErrors('Data penjualan tidak ditemukan.');
        }

        return view('keranjang.struk', [
            'penjualan' => $penjualan,
            'pelanggan' => $penjualan->pelanggan,
            'detailPenjualan' => $penjualan->detailPenjualan,
        ]);
    }

    public function pembayaran(Request $request)
    {
        $userId = auth()->user()->user_id;
        $namaPelanggan = $request->input('nama_pelanggan');
        $alamatPelanggan = $request->input('alamat_pelanggan');
        $nomorTelepon = $request->input('nomor_telepon');

        $pelanggan = Pelanggan::create([
            'nama_pelanggan' => $namaPelanggan,
            'alamat_pelanggan' => $alamatPelanggan,
            'nomor_telepon' => $nomorTelepon
        ]);

        if ($pelanggan) {
            $pelangganId = $pelanggan->pelanggan_id;

            $keranjang = session('keranjang', []);

            $nilai_subtotal = array_column($keranjang, 'subtotal');
            $total = array_sum($nilai_subtotal);

            $penjualan = Penjualan::create([
                'tanggal_penjualan'  => Carbon::now(),
                'total_harga' => $total,
                'pelanggan_id' => $pelangganId,
                'user_id' => $userId,
            ]);

            if ($penjualan) {
                $penjualanId = $penjualan->penjualan_id;

                foreach ($keranjang as $item) {
                    $detailPenjualan = DetailPenjualan::create([
                        'penjualan_id' => $penjualanId,
                        'produk_id' => $item['produk_id'],
                        'jumlah_produk' => $item['jumlah'],
                        'subtotal' => $item['subtotal']
                    ]);

                    $produk = Produk::find($item['produk_id']);
                    if ($produk) {
                        // Kurangi stok produk
                        $produk->stok -= $item['jumlah'];
                        $produk->save();
                    }
                }

                if ($detailPenjualan) {

                    $produk = Produk::find($item['produk_id']);
                    if ($produk) {
                        // Kurangi stok produk
                        $produk->stok -= $item['jumlah'];
                        $produk->save();
                    }

                    Session::forget('keranjang');
                    return redirect()->route('keranjang.struk', ['id_penjualan' => $penjualanId]);
                }
            }
        }
    }
=======
>>>>>>> d69980d7bc03db9fb85d1c0efc33f79291e24f26
}
