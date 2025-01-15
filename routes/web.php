<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProdukController;
use Illuminate\Support\Facades\Route;

// Login
Route::get('/', [LoginController::class,'login'])->name('login');
Route::post('/login', [LoginController::class,'cekLogin'])->name('cekLogin');
Route::get('/actionlogout', [LoginController::class, 'logout'])->name('logout');
// Route::get('home', [HomeController::class, 'index'])->name('home')->middleware('auth');

// Produk
Route::get('/produk', [ProdukController::class,'index'])->name('produk');
Route::get('/produk/tambah', [ProdukController::class,'create'])->name('produk.create');
Route::post('/produk', [ProdukController::class,'store'])->name('produk.store');
Route::get('/produk/{id}', [ProdukController::class,'show']);
Route::get('/produk/{id}/edit', [ProdukController::class,'edit'])->name('produk.edit');
Route::post('/produk/{id}', [ProdukController::class,'update'])->name('produk.update');
Route::delete('/produk/{id}', [ProdukController::class,'delete'])->name('produk.delete');
