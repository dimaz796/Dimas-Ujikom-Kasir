<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Produk extends Model
{
    use HasFactory;

    protected $table = 'produk';

    protected $primaryKey = 'produk_id';

    protected $fillable = [
        'nama_produk',
        'harga',
        'stok',
        'foto',
    ];
}
