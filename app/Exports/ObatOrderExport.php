<?php

namespace App\Exports;

use App\Models\Obat;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Border;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ObatOrderExport implements FromCollection, WithHeadings, ShouldAutoSize, WithStyles
{
    
    public function collection()
    {
        // nama_obat	stock_awal	pemakaian	pemasukan	min_stock	satuan

        return Obat::where('status_stock', 'Tidak Aman')
            ->select('nama_obat', 'stock_awal', 'pemakaian', 'pemasukan',  'min_stock',  'satuan')
            ->get();
    }

    /**
     * Menentukan header kolom di file Excel
     */
    public function headings(): array
    {
        return [
            'nama_obat','stock_awal','pemakaian', 'pemasukan', 'min_stock', 'satuan'
        ];
    }

    /**
     * Styling untuk mempercantik tampilan Excel
     */
    public function styles(Worksheet $sheet)
    {
        // Membuat border untuk seluruh sel yang berisi data
        $totalRows = $sheet->getHighestRow();
        $totalColumns = $sheet->getHighestColumn();
        $range = "A1:{$totalColumns}{$totalRows}";

        $sheet->getStyle($range)->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => '000000'], // Warna hitam
                ],
            ],
        ]);

        // Membuat teks header tebal
        $sheet->getStyle('A1:F1')->applyFromArray([
            'font' => [
                'bold' => true,
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['argb' => 'FFFFCC'], // Warna kuning muda untuk header
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);
    }
}
