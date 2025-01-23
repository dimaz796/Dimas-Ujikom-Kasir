<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;



// Login
Route::get('/', [LoginController::class, 'login'])->name('login');
Route::post('/login', [LoginController::class, 'cekLogin'])->name('cekLogin');
Route::get('/actionlogout', [LoginController::class, 'logout'])->name('logout');
// Route::get('home', [HomeController::class, 'index'])->name('home')->middleware('auth');

Route::middleware(['auth'])->group(function () {
    // Home
    Route::get('/beranda', [HomeController::class, 'index'])->name('home');
    Route::get('/beranda/search', [HomeController::class, 'index'])->name('produk.search');
    Route::post('/beranda/tambah', [HomeController::class, 'tambahKeranjang'])->name('keranjang');

    // Keranjang
    Route::get('/keranjang', [CartController::class, 'index'])->name('keranjang.index');
    Route::post('/keranjang/update', [CartController::class, 'updateKeranjang'])->name('keranjang.update');
    Route::post('/keranjang/hapus', [CartController::class, 'hapusProduk'])->name('keranjang.hapus');
    Route::post('/keranjang/pembayaran', [CartController::class, 'pembayaran'])->name('keranjang.pembayaran');
    Route::get('/keranjang/struk', [CartController::class, 'struk'])->name('keranjang.struk');

    // Produk
    Route::get('/produk', [ProdukController::class, 'index'])->name('produk');
    Route::get('/produk/tambah', [ProdukController::class, 'create'])->name('produk.create');
    Route::post('/produk', [ProdukController::class, 'store'])->name('produk.store');
    Route::get('/produk/{id}/edit', [ProdukController::class, 'edit'])->name('produk.edit');
    Route::post('/produk/{id}', [ProdukController::class, 'update'])->name('produk.update');
    Route::delete('/produk/{id}', [ProdukController::class, 'delete'])->name('produk.delete');
    Route::get('/produk/{id}', [ProdukController::class, 'show'])->name('produk.show');
});
// Keranjang
Route::get('/keranjang', [CartController::class, 'index'])->name('keranjang.index');
Route::post('/keranjang/update', [CartController::class, 'updateKeranjang'])->name('keranjang.update');
Route::post('/keranjang/hapus', [CartController::class, 'hapusProduk'])->name('keranjang.hapus');


Route::middleware(['auth'])->group(function () {
    //User
    Route::get('/user', [UserController::class, 'index'])->name('user');
    Route::get('/user/tambah', [UserController::class, 'create'])->name('user.create');
    Route::post('/user', [UserController::class, 'store'])->name('user.store');
    Route::get('/user/{id}/edit', [UserController::class, 'edit'])->name('user.edit');
    Route::post('/user/{id}', [UserController::class, 'update'])->name('user.update');
    Route::delete('/user/{id}', [UserController::class, 'delete'])->name('user.delete');
});
