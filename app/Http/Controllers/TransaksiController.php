<?php

namespace App\Http\Controllers;

use App\Models\Penjualan;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    
    public function index()
    {
        $transaksi = Penjualan::with(['pelanggan','user'])->get();


        return view('transaksi.index', compact('transaksi'));
    }

}
