<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $produk = Produk::oldest()->paginate(10);
        $currentDate = Carbon::now();
        
        return view('home.index', compact('produk','currentDate'));
    }

}
