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

        $currentDateDmy = Carbon::now()->format('dmY');

        $jumlahTransaksi = Penjualan::whereDate('tanggal_penjualan', $currentDate)->count() + 1;

        $nomor_transaksi = $currentDateDmy . $jumlahTransaksi;

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

        Session::put('keranjang', $keranjang);

        return view('keranjang.index', compact('keranjang', 'nomor_transaksi', 'totalKeranjang'));
    }

    public function updateKeranjang(Request $request)
    {
        $produkId = $request->input('produk_id');
        $subtotal = $request->input('subtotal');
        $jumlah = $request->input('jumlah');
        $harga = $request->input('harga');

        $keranjang = Session::get('keranjang', []);

        if (isset($keranjang[$produkId])) {
            $keranjang[$produkId]['jumlah'] = $jumlah;
            $keranjang[$produkId]['subtotal'] = $subtotal;
        } else {
            $keranjang[$produkId] = [
                'produk_id' => $produkId,
                'jumlah' => $jumlah,
                'harga' => $harga,
                'subtotal' => $subtotal,
            ];
        }

        Session::put('keranjang', $keranjang);

        return response()->json(['status' => 'success']);
    }

    public function hapusProduk(Request $request)
    {
        $produkId = $request->input('produk_id');

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

        return response()->json([
            'status' => 'error',
            'message' => 'Produk tidak ditemukan di keranjang',
        ]);
    }



    public function pembayaran(Request $request)
    {
        $userId = auth()->user()->user_id;

        $nominalPembayaran = str_replace('.', '', $request->input('nominal_pembayaran'));
        $keranjang = session('keranjang', []);


        $nilai_subtotal = array_column($keranjang, 'subtotal');
        $total = array_sum($nilai_subtotal);

        $kodePelanggan = null;


        if ($nominalPembayaran < $total) {
            return redirect()->back()->with('error', 'Uang anda kurang.')
                ->withInput();
        }

        if ($request->keterangan == 'member') {
            $request->validate([
                'pelanggan_id' => 'required|digits:3',
            ], [
                'pelanggan_id.required' => 'ID Pelanggan wajib diisi!',
                'pelanggan_id.digits' => 'ID Pelanggan harus terdiri dari 3 digit angka!',
            ]);

            $pelangganRequest = 'SQ' . $request->pelanggan_id;
            $pelanggan = Pelanggan::where('pelanggan_id', $pelangganRequest)->first();

            if (!$pelanggan) {
                return redirect()->back()->with('error', 'Pelanggan tidak ditemukan')
                    ->withInput();
            }
            $kodePelanggan = $pelanggan->getAttributes()['pelanggan_id'];
            if ($pelanggan) {
                $namaPelanggan = $pelanggan->nama_pelanggan;
                $alamatPelanggan = $pelanggan->alamat_pelanggan;
                $nomorTelepon = $pelanggan->nomor_telepon;
            }
        } elseif($request->keterangan == 'non_member') {
            $namaPelanggan = $request->nama_pelanggan;
            $alamatPelanggan = $request->alamat_pelanggan;
            $nomorTelepon = $request->nomor_telepon;

            if (!empty($namaPelanggan) && !empty($alamatPelanggan) && !empty($nomorTelepon)) {
                $lastPelanggan = Pelanggan::orderBy('pelanggan_id', 'desc')->first();

                if ($lastPelanggan) {
                    $LastKodePelanggan = $lastPelanggan->getAttributes()['pelanggan_id'];
                    $lastCode = (int) substr($LastKodePelanggan, 2);
                } else {
                    $lastCode = 0;
                }

                $newCode = $lastCode + 1;

                $kodePelanggan = 'SQ' . str_pad($newCode, 5 - 2, '0', STR_PAD_LEFT);

                $pelanggan = Pelanggan::create([
                    'pelanggan_id' => $kodePelanggan,
                    'nama_pelanggan' => $namaPelanggan,
                    'alamat_pelanggan' => $alamatPelanggan,
                    'nomor_telepon' => $nomorTelepon
                ]);
            } else {
                $pelanggan = null;
            }
        }

        if ($keranjang) {

            $pelangganId = $kodePelanggan;

            $currentDateCek = Carbon::now()->toDateString();
            $jumlahTransaksi = Penjualan::whereDate('created_at', $currentDateCek)->count() + 1;
            $penjualanId = Carbon::now()->format('dmY') . str_pad($jumlahTransaksi, 3, '0', STR_PAD_LEFT);

            $penjualan = Penjualan::create([
                'penjualan_id' => $penjualanId,
                'tanggal_penjualan'  => Carbon::now(),
                'total_harga' => $total,
                'pelanggan_id' => $pelangganId,
                'user_id' => $userId,
                'nominal_pembayaran' => $nominalPembayaran,
                'kembalian' => $nominalPembayaran - $total,
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
                        $produk->stok -= $item['jumlah'];
                        $produk->save();
                    }
                }

                if ($detailPenjualan && $produk) {
                    Session::forget('keranjang');
                    return redirect()->route('keranjang.struk', ['id_penjualan' => $penjualanId]);
                }
            }
        } else {
            Session::forget('keranjang');
            return redirect()->route('home')->with('error', 'Transaksi gagal, keranjang kosong.');
        }
    }

    public function struk(Request $request)
    {
        $penjualan_id = $request->input('id_penjualan');

        $penjualan = Penjualan::with(['pelanggan', 'detailPenjualan.produk','user'])
            ->where('penjualan_id', $penjualan_id)
            ->first();

        if (!$penjualan) {
            return redirect()->back()->withErrors('Data penjualan tidak ditemukan.');
        }

        return view('keranjang.struk', [
            'penjualan' => $penjualan,
            'pelanggan' => $penjualan->pelanggan,
            'user' => $penjualan->user,
            'detailPenjualan' => $penjualan->detailPenjualan,
        ]);
    }

    public function cariPelanggan($id)
    {
        $pelanggan = Pelanggan::where('pelanggan_id', $id)->first();

        if ($pelanggan) {
            return response()->json([
                'success' => true,
                'pelanggan' => $pelanggan
            ]);
        } else {
            return response()->json(['success' => false]);
        }
    }

}
