<?php
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Login
Route::get('/', [LoginController::class, 'login'])->name('login');
Route::post('/login', [LoginController::class, 'cekLogin'])->name('cekLogin');
Route::get('/actionlogout', [LoginController::class, 'logout'])->name('logout');

// Route bisa diakses oleh admin dan petugas (user yang sudah login)
Route::middleware(['auth'])->group(function () {
    // Home
    Route::get('/beranda', [HomeController::class, 'index'])->name('home');
    Route::get('/beranda/search', [HomeController::class, 'index'])->name('beranda.search');
    Route::post('/beranda/tambah', [HomeController::class, 'tambahKeranjang'])->name('keranjang');

    // Keranjang
    Route::get('/keranjang', [CartController::class, 'index'])->name('keranjang.index');
    Route::post('/keranjang/update', [CartController::class, 'updateKeranjang'])->name('keranjang.update');
    Route::post('/keranjang/hapus', [CartController::class, 'hapusProduk'])->name('keranjang.hapus');
    Route::post('/keranjang/pembayaran', [CartController::class, 'pembayaran'])->name('keranjang.pembayaran');
    Route::get('/keranjang/struk', [CartController::class, 'struk'])->name('keranjang.struk');


    // Produk
    Route::get('/produk/search', [ProdukController::class, 'search'])->name('produk.search');
    Route::get('/produk/restock', [ProdukController::class, 'restock'])->name('produk.restock');
    Route::get('/produk', [ProdukController::class, 'index'])->name('produk');
    Route::get('/produk/tambah', [ProdukController::class, 'create'])->name('produk.create');
    Route::post('/produk', [ProdukController::class, 'store'])->name('produk.store');
    Route::get('/produk/{id}/edit', [ProdukController::class, 'edit'])->name('produk.edit');
    Route::post('/produk/{id}', [ProdukController::class, 'update'])->name('produk.update');
    Route::delete('/produk/{id}', [ProdukController::class, 'delete'])->name('produk.delete');
    Route::get('/produk/{id}', [ProdukController::class, 'show'])->name('produk.show');
    

    //Riwayat Transaksi
    Route::get('/riwayat-transaksi', [TransaksiController::class, 'riwayatTransaksi'])->name('riwayat_transaksi');


});

// Route hanya bisa diakses oleh admin
Route::middleware(['auth', 'role:admin'])->group(function () {
    // User
    Route::get('/user/search', [UserController::class, 'search'])->name('user.search');
    Route::get('/user', [UserController::class, 'index'])->name('user');
    Route::get('/user/tambah', [UserController::class, 'create'])->name('user.create');
    Route::post('/user', [UserController::class, 'store'])->name('user.store');
    Route::get('/user/{id}/edit', [UserController::class, 'edit'])->name('user.edit');
    Route::post('/user/{id}', [UserController::class, 'update'])->name('user.update');
    Route::delete('/user/{id}', [UserController::class, 'delete'])->name('user.delete');

    // Transaksi Data
    Route::get('/transaksi/print-pdf', [TransaksiController::class, 'printPDF'])->name('transaksi.printPDF');
    Route::get('/data-transaksi', [TransaksiController::class, 'index'])->name('transaksi');
    Route::post('/laporan', [TransaksiController::class, 'laporan'])->name('laporan');
    Route::get('transaksi/exportToExcel', [TransaksiController::class, 'exportToExcel'])->name('transaksi.exportToExcel');
    Route::get('transaksi/exportToPDF', [TransaksiController::class, 'exportToPDF'])->name('transaksi.exportToPDF');
});
