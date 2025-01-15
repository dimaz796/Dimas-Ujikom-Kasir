<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DetailPenjualan extends Model
{
    use HasFactory;

    protected $table = 'detail_penjualan';

    protected $fillable = [
        'penjualan_id',
        'produk_id',
        'jumlah_produk',
        'subtotal',
    ];

    public function penjualan(){
        return $this->belongsTo(Penjualan::class, 'penjualan_id');
    }

    public function produk(){
        return $this->belongsTo(Produk::class, 'produk_id');
    }
}
