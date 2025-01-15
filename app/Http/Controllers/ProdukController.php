<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    public function index()
    {
        $produk = Produk::latest()->paginate(10);

        return view('produk.index', compact('produk'));
    }
    
    public function show($id)
    {
        $produk = Produk::findOrFail($id);
        return view('produk.show', compact('products'));
    }
    
    public function create()
    {
        return view('produk.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama_produk' => 'required|string|max:255',
            'harga' => 'required|integer|min:0',
            'stok' => 'required|integer|min:0',
            'foto' => 'nullable|string',
        ]);

        $produk = Produk::create($validatedData);

        return redirect('/produk')->with('success','Produk Berhasil Ditambahkan!');
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
            'foto' => 'nullable|string',
        ]);
        
        $produk = Produk::findOrFail($id);
        $produk->update($validatedData);

        return redirect('/produk')->with('success','Produk Berhasil Diperbaharui!');
    }
    
    public function delete($id)
    {
        $produk = Produk::findOrFail($id);
        $produk->delete();

        return redirect('/produk')->with('success','Produk Berhasil Dihapus!');
    }
}
