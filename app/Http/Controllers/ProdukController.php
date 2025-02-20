<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;
use PHPUnit\Framework\Constraint\FileExists;

class ProdukController extends Controller
{

    public function search(Request $request)
    {
        $search = $request->input('search');

        if (!$search) {
            return redirect()->route('produk');
        }

        $produk = Produk::where('status','active')
                         ->where('nama_produk', 'like', '%' . $search . '%')->oldest()->paginate(10);

        $cekStok = Produk::where('status','active')
                        ->where('stok', '<', 25)->get()->count();

        return view('produk.index', compact('produk','cekStok'));
    }

    public function restock(Request $request)
    {
        $produk = Produk::where('status','active')
                        ->where('stok', '<', 25)->paginate(10);

        $cekStok = $produk->count();

        return view('produk.index', compact('produk','cekStok'));
    }


    public function index()
    {
        $produk = Produk::where('status','active')->oldest()->paginate(10);


        $cekStok = Produk::where('status','active')
                            ->where('stok', '<', 25)->get()->count();

        return view('produk.index', compact('produk','cekStok'));
    }

    public function show($id)
    {
        $produk = Produk::findOrFail($id);
        return view('produk.show', compact('produk'));
    }

    public function create()
    {
        return view('produk.tambah');
    }

    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'nama_produk' => 'required|string|max:255',
            'harga' => 'required|integer|min:0',
            'stok' => 'required|integer|min:0',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            $file_nama = $request->file('foto')->getClientOriginalName();

            $file_path = $request->file('foto')->storeAs('produk', $file_nama, 'public');

            $validatedData['foto'] = $file_path;
        }

        $produk = Produk::create($validatedData);

        return redirect()->route('produk')->with('success','Produk Berhasil Ditambahkan!');
    }

    public function edit($id)
    {
        $produk = Produk::findOrFail($id);
        return view('produk.edit', compact('produk'));
    }


    public function update(Request $request,$id)
    {
        $validatedData = $request->validate([
            'nama_produk' => 'required|string|max:255',
            'harga' => 'required|integer|min:0',
            'stok' => 'required|integer|min:0',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $produk = Produk::findOrFail($id);

        if ($request->hasFile('foto')) {

            if ($produk->foto) {
                $oldFilePath = storage_path('app/public/' . $produk->foto);
                if (file_exists($oldFilePath)) {
                    unlink($oldFilePath);
                }
            }

            $file_nama = $request->file('foto')->getClientOriginalName();
            $file_path = $request->file('foto')->storeAs('produk',$file_nama,'public');

            $validatedData['foto'] = $file_path;
        }

        $produk->update($validatedData);

        return redirect('/produk')->with('success','Produk Berhasil Diperbaharui!');
    }

    public function stock($id)
    {
        $produk = Produk::findOrFail($id);

        return view('produk.halaman_stok', compact('produk'));
    }

    public function delete($id)
    {
        $produk = Produk::findOrFail($id);
        $produk->status = 'inactive';
        $produk->save();

        return redirect('/produk')->with('success','Produk Berhasil Dihapus!');
    }


}
