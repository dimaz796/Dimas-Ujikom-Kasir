# Aplikasi Kasir Ujikom

Aplikasi Kasir ini adalah aplikasi yang digunakan untuk ujian komprehensif (Ujikom) untuk tujuan pembelajaran dan evaluasi. Aplikasi ini memungkinkan pengguna untuk melakukan transaksi penjualan produk, mengelola data produk, dan memproses pembayaran.

## Persyaratan

Sebelum memulai, pastikan Anda memiliki:

-   **PHP** (Disarankan versi terbaru)

-   **Composer**

-   **Node.js** dan **NPM**

-   **XAMPP** (atau server lokal dengan PHP dan MySQL)

## Instalasi

Ikuti langkah-langkah berikut untuk menginstal aplikasi:

-   Clone repositori ini ke komputer Anda:

```bash
git clone https://github.com/dimaz796/Dimas-Ujikom-Kasir.git
```

-   Masuk ke direktori proyek:

```bash
cd Dimas-Ujikom-Kasir
```

-   Buka file php.ini pada XAMPP dan aktifkan ekstensi berikut dengan menghapus tanda titik koma ( ; ) :

```bash
extension=gd
extension=zip
```

-   Install dependencies dengan Composer dan NPM:

```bash
composer install
npm install
```

-   Migrasi database dan seeding data:

```bash
php artisan migrate --seed
```

-   Buat symbolic link untuk storage:

```bash
php artisan storage:link
```

-   Jalankan Vite untuk membangun asset frontend:

```bash
npm run dev
```

-   Jalankan server Laravel:

```bash
php artisan serve
```

## Login

Gunakan kredensial berikut untuk masuk ke aplikasi:

-   **Email** : test@example.com

-   **Password** : test

Setelah berhasil login, Anda akan diarahkan ke halaman utama aplikasi kasir.

## Fitur Utama

-   Manajemen Produk: Menambah, mengedit, dan menghapus produk yang tersedia di aplikasi.

-   Transaksi Penjualan: Mengelola transaksi penjualan dan menghitung total harga.

-   Laporan: Menampilkan laporan transaksi dan produk yang terjual.

-   Login Sistem: Pengguna dapat login untuk mengakses aplikasi dan melakukan transaksi.

## Lisensi

Proyek ini dibuat untuk keperluan pembelajaran dan ujian komprehensif (Ujikom).
