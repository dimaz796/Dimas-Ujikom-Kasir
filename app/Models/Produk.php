<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Produk extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'produk';

    protected $primaryKey = 'produk_id';

    protected $fillable = [
        'nama_produk',
        'harga',
        'stok',
        'foto',
    ];
}
