<?php

namespace Database\Factories;

use App\Models\Produk;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;

class ProdukFactory extends Factory
{
    protected $model = Produk::class;

    public function definition()
    {
        $files = Storage::disk('public')->files('produk');

        return [
            'nama_produk' => $this->faker->word,
            'harga' => $this->faker->numberBetween(10000, 1000000),
            'stok' => $this->faker->numberBetween(1, 100),
            'foto' => count($files) > 0 ? '' . $files[array_rand($files)] : null,
        ];
    }
}

