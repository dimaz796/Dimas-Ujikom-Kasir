<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Penjualan extends Model
{
    use HasFactory;

    protected $table = 'penjualan';

    protected $fillable = [
        'tanggal_penjualan',
        'total_harga',
        'pelanggan_id',
        'user_id',
    ];

    public function pelanggan(){
             return $this->belongsTo(Pelanggan::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function detail_penjualans(){
        return $this->hasMany(DetailPenjualan::class);
    }
}
