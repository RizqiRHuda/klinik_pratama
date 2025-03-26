<?php
namespace App\Exports;

use App\Models\Terapi;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class DataTerapiExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithEvents
{
    protected $from;
    protected $to;

    public function __construct($from, $to)
    {
        $this->from = $from;
        $this->to = $to;
    }

    public function collection()
    {
        return Terapi::with(['pasien', 'jenisLayanan', 'obat'])
            ->whereBetween('tgl_terapi', [$this->from, $this->to])
            ->get();
    }

    public function headings(): array
    {
        return [
            ['Data Terapi Pasien Klinik Pratama'], // Judul laporan
            ["Periode: {$this->from} s.d {$this->to}"], // Periode laporan
            [], // Baris kosong untuk pemisah
            [
                'Tanggal Terapi', 'No. RM', 'Nama Pasien', 'NIK', 'Alamat', 'No HP',
                'Tanggal Lahir', 'Jenis Kelamin', 'Pekerjaan', 'Riwayat Alergi',
                'Anamnesa', 'Pemeriksaan', 'Diagnosa',  'Jenis Layanan', 'Nama Obat'
            ]
        ];
    }

    public function map($terapi): array
    {
        return [
            $terapi->tgl_terapi,
            $terapi->pasien->no_rm,
            $terapi->pasien->nama_pasien,
            $terapi->pasien->nik,
            $terapi->pasien->alamat,
            $terapi->pasien->no_hp,
            $terapi->pasien->tgl_lahir,
            $terapi->pasien->jk,
            $terapi->pasien->pekerjaan,
            $terapi->pasien->riwayat_alergi,
            $terapi->anamnesa,
            $this->formatPemeriksaan($terapi->pemeriksaan), // Format pemeriksaan agar lebih rapi
            $terapi->diagnosa,
            ($terapi->jenisLayanan->nama == 'rujuk') ? 'Rujuk' : 'Rawat Jalan',
            $terapi->obat->pluck('nama_obat')->implode(', ')
        ];
    }

    private function formatPemeriksaan($pemeriksaan)
    {
        if (!is_array($pemeriksaan)) {
            $pemeriksaan = json_decode($pemeriksaan, true);
        }

        if (is_array($pemeriksaan)) {
            return collect($pemeriksaan)
                ->map(fn($v, $k) => "$k: $v") // Format "tb: 1, bb: 1, suhu: 1"
                ->implode(', ');
        }

        return $pemeriksaan;
    }

    public function styles(Worksheet $sheet)
    {
        $totalRows = $this->collection()->count() + 4; // +4 untuk judul dan header

        // Border untuk seluruh tabel
        $sheet->getStyle("A4:O$totalRows")->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '000000'],
                ],
            ],
        ]);

        // Header tebal dan berwarna hijau
        $sheet->getStyle('A4:O4')->applyFromArray([
            'font' => ['bold' => true, 'color' => ['argb' => 'FFFFFFFF']],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['argb' => 'FF4CAF50'],
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            ],
        ]);

        // Judul laporan
        $sheet->mergeCells('A1:O1');
        $sheet->getStyle('A1')->applyFromArray([
            'font' => ['bold' => true, 'size' => 14],
            'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
        ]);

        // Periode laporan
        $sheet->mergeCells('A2:O2');
        $sheet->getStyle('A2')->applyFromArray([
            'font' => ['italic' => true],
            'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
        ]);
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet;

                // Auto width semua kolom
                foreach (range('A', 'O') as $col) {
                    $sheet->getColumnDimension($col)->setAutoSize(true);
                }
            },
        ];
    }
}
