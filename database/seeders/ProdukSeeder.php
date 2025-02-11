<?php

namespace Database\Seeders;

use App\Models\Produk;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class ProdukSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Pastikan path sesuai dengan lokasi file JSON
        $jsonPath = database_path('json/data-produk.json');

        // Periksa apakah file ada sebelum mencoba membacanya
        if (!File::exists($jsonPath)) {
            throw new \Exception("File tidak ditemukan di path: $jsonPath");
        }

        // Baca isi file JSON
        $json = File::get($jsonPath);
        $produk = json_decode($json, true);

        // Pastikan JSON berhasil di-decode
        if ($produk === null) {
            throw new \Exception("Gagal membaca atau mengurai JSON dari file: $jsonPath");
        }

        // Insert data ke tabel produk
        foreach ($produk as $data) {
            Produk::create($data);
        }
    }
}
