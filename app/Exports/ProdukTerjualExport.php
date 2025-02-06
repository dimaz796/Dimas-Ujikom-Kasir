<?php

namespace App\Exports;

use App\Models\DetailPenjualan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ProdukTerjualExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithEvents
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
        $produkTerjual->push((object) [
            'produk' => 'Grand Total',
            'total_jual' => null, // Tidak perlu kolom kosong
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
        static $no = 1;
        if ($produk->produk == 'Grand Total') {
            return [
                'Grand Total', // Ditaruh di kolom pertama
                '', // Kosongkan kolom kedua
                '', // Kosongkan kolom ketiga
                'Rp ' . number_format($produk->total_harga, 0, ',', '.'), // Pastikan total harga tetap muncul di kolom D
            ];
        }

        return [
            $no++,
            $produk->produk->nama_produk,
            $produk->total_jual,
            'Rp ' . number_format($produk->total_harga, 0, ',', '.'),
        ];
    }

    public function styles(Worksheet $sheet)
{
    $highestRow = $sheet->getHighestRow();

    // Tambahkan border ke seluruh tabel
    $sheet->getStyle("A1:D{$highestRow}")->applyFromArray([
        'borders' => [
            'allBorders' => [
                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
            ],
        ],
    ]);

    // Styling header (background biru tua dan teks putih)
    $sheet->getStyle("A1:D1")->applyFromArray([
        'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
        'fill' => [
            'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
            'startColor' => ['rgb' => '000080'],
        ],
        'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
    ]);

    // **Lebarkan kolom secara manual agar tidak terlalu jauh**
    $sheet->getColumnDimension('A')->setWidth(5);   // Nomor lebih kecil
    $sheet->getColumnDimension('B')->setWidth(30);  // Nama produk tetap dalam ukuran yang wajar
    $sheet->getColumnDimension('C')->setWidth(15);  // Jumlah terjual
    $sheet->getColumnDimension('D')->setWidth(20);  // Total harga

    // **Ratakan teks pada kolom "Produk" ke kiri agar tidak terlalu jauh**
    $sheet->getStyle("B2:B{$highestRow}")->applyFromArray([
        'alignment' => [
            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
        ],
    ]);

    // **Tinggi baris otomatis menyesuaikan isi**
    for ($row = 1; $row <= $highestRow; $row++) {
        $sheet->getRowDimension($row)->setRowHeight(-1);
    }
}


    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $highestRow = $sheet->getHighestRow();

                // Merge kolom Grand Total (A sampai C)
                $sheet->mergeCells("A{$highestRow}:C{$highestRow}");

                // Styling Grand Total
                $sheet->getStyle("A{$highestRow}:D{$highestRow}")->applyFromArray([
                    'font' => ['bold' => true, 'size' => 14], // Perbesar font
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                    ],
                ]);

                // Tinggikan baris Grand Total agar lebih terlihat
                $sheet->getRowDimension($highestRow)->setRowHeight(30);
            },
        ];
    }
}
