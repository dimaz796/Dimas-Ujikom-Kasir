<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Pelanggan extends Model
{
    use HasFactory;

    protected $table = 'pelanggan';
    protected $primaryKey = 'pelanggan_id';

    protected $fillable = [
        'nama_pelanggan',
        'alamat_pelanggan',
        'nomor_telepon',
    ];

    public function penjualans()
    {
        return $this->hasMany(Penjualan::class);
    }
}
