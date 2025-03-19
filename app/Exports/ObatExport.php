<?php

namespace App\Exports;

use App\Models\Obat;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class ObatExport implements FromCollection, WithHeadings, WithTitle, WithStyles, WithColumnWidths
{
    /**
     * Mengambil data obat dari database dan menambahkan nomor urut.
     */
    public function collection()
    {
        $obat = Obat::select(
            'nama_obat',
            'stock_awal',
            'pemakaian',
            'pemasukan',
            'stock_akhir',
            'min_stock',
            'status_stock',
            'satuan'
        )->get();

        // Tambahkan nomor urut
        return $obat->map(function ($item, $index) {
            return [
                'No'          => $index + 1,
                'Nama Obat'   => $item->nama_obat,
                'Stock Awal'  => $item->stock_awal,
                'Pemakaian'   => $item->pemakaian,
                'Pemasukan'   => $item->pemasukan,
                'Stock Akhir' => $item->stock_akhir,
                'Min Stock'   => $item->min_stock,
                'Status'      => $item->status_stock,
                'Satuan'      => $item->satuan,
            ];
        });
    }

    /**
     * Menentukan header kolom.
     */
    public function headings(): array
    {
        return [
            ['Daftar Obat Klinik Pratama Gawang'], // Judul di baris pertama
            [''], // Baris kosong untuk jarak
            [ // Header tabel
                'No',
                'Nama Obat',
                'Stock Awal',
                'Pemakaian',
                'Pemasukan',
                'Stock Akhir',
                'Min Stock',
                'Status Stock',
                'Satuan',
            ]
        ];
    }

    /**
     * Menentukan judul sheet pada file Excel.
     */
    public function title(): string
    {
        return 'Data Obat';
    }

    /**
     * Menentukan gaya tampilan di Excel.
     */
    public function styles(Worksheet $sheet)
    {
        // Judul laporan di tengah dan tebal
        $sheet->mergeCells('A1:I1'); 
        $sheet->getStyle('A1')->applyFromArray([
            'font' => ['bold' => true, 'size' => 14],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]
        ]);

        // Header tabel tebal dan rata tengah
        $sheet->getStyle('A3:I3')->applyFromArray([
            'font' => ['bold' => true],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
            'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]]
        ]);

        // Border untuk seluruh tabel
        $lastRow = 3 + Obat::count(); // Baris terakhir data
        $sheet->getStyle("A3:I$lastRow")->applyFromArray([
            'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]]
        ]);
    }

    /**
     * Menentukan lebar kolom agar lebih rapi.
     */
    public function columnWidths(): array
    {
        return [
            'A' => 5,   // No
            'B' => 30,  // Nama Obat
            'C' => 12,  // Stock Awal
            'D' => 12,  // Pemakaian
            'E' => 12,  // Pemasukan
            'F' => 12,  // Stock Akhir
            'G' => 12,  // Min Stock
            'H' => 15,  // Status Stock
            'I' => 10,  // Satuan
        ];
    }
}
