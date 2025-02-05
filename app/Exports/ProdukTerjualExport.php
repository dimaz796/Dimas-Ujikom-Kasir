<?php

namespace App\Exports;

use App\Models\DetailPenjualan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProdukTerjualExport implements FromCollection, WithHeadings
{
    protected $startDate;
    protected $endDate;

    public function __construct($startDate, $endDate)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function collection()
    {
        // Menggunakan query builder untuk memilih data dengan selectRaw
        return DetailPenjualan::with('produk')
            ->whereBetween('created_at', [$this->startDate, $this->endDate])
            ->groupBy('produk_id')
            ->selectRaw('produk_id, sum(jumlah_produk) as total_jual, sum(subtotal) as total_harga')
            ->orderByDesc('total_jual')
            ->get() // Ambil data yang sudah diproses
            ->map(function ($item, $index) {
                // Format data untuk dimasukkan ke dalam Excel
                return [
                    'No' => $index + 1,
                    'Produk' => $item->produk->nama_produk,
                    'Jumlah Terjual' => $item->total_jual,
                    'Total' => 'Rp ' . number_format($item->total_harga, 0, ',', '.'),
                ];
            });
    }

    public function headings(): array
    {
        return [
            'No',
            'Produk',
            'Jumlah Terjual',
            'Total',
        ];
    }
}
