<?php

namespace App\Exports;

use App\Models\DetailPenjualan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ProdukTerjualExport implements FromCollection, WithHeadings, WithMapping
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
        // Ambil data produk yang dijual dalam rentang waktu yang ditentukan
        $produkTerjual = DetailPenjualan::with('produk')
            ->whereBetween('created_at', [$this->startDate, $this->endDate])
            ->groupBy('produk_id')
            ->selectRaw('produk_id, sum(jumlah_produk) as total_jual, sum(subtotal) as total_harga')
            ->orderByDesc('total_jual')
            ->get();

        // Hitung Grand Total
        $grandTotal = $produkTerjual->sum('total_harga');

        // Menambahkan data Grand Total ke collection
        $produkTerjual->push([
            'produk' => 'Grand Total',
            'total_jual' => '',
            'total_harga' => $grandTotal,
        ]);

        return $produkTerjual;
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

    public function map($produk): array
    {
        // Jika baris adalah Grand Total, tampilkan hanya Total dan kosongkan Jumlah Terjual
        static $no = 1; // Gunakan static untuk menjaga nilai urutan No
        if ($produk['produk'] == 'Grand Total') {
            return [
                '', // Kosongkan No untuk Grand Total
                $produk['produk'], // Tampilkan Grand Total
                '', // Kosongkan Jumlah Terjual
                'Rp ' . number_format($produk['total_harga'], 0, ',', '.'),
            ];
        }

        // Untuk data produk lainnya
        return [
            $no++, // Increment No untuk setiap produk
            $produk->produk->nama_produk,
            $produk['total_jual'],
            'Rp ' . number_format($produk['total_harga'], 0, ',', '.'),
        ];
    }
}
