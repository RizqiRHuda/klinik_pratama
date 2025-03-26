<?php

namespace App\Exports;

use App\Models\Terapi;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class DetailTerapiExport implements FromArray, WithStyles
{
    protected $terapi;

    public function __construct($terapi)
    {
        $this->terapi = $terapi;
    }

    public function array(): array
    {
        $terapi = $this->terapi;
        $pemeriksaan = json_decode($terapi->pemeriksaan, true);

        return [
            ['Data Personal Pasien Terapi'], // Judul Utama
            [''], // Baris Kosong
            ['Nama Pasien', 'No RM', 'NIK', 'Alamat', 'No HP', 'Tanggal Lahir', 'Jenis Kelamin', 'Pekerjaan', 'Riwayat Alergi'],
            [$terapi->pasien->nama_pasien, $terapi->pasien->no_rm, $terapi->pasien->nik, $terapi->pasien->alamat, 
             $terapi->pasien->no_hp, $terapi->pasien->tgl_lahir, $terapi->pasien->jk, 
             $terapi->pasien->pekerjaan, $terapi->pasien->riwayat_alergi ?? '-'],
            
            [''], // Baris Kosong
            ['Detail Pemeriksaan Terapi'], // Subjudul
            ['Tanggal Terapi', 'Anamnesa', 'Diagnosa', 'Jenis Layanan'],
            [$terapi->tgl_terapi, $terapi->anamnesa, $terapi->diagnosa, $terapi->jenisLayanan->nama],
            
            [''], // Baris Kosong
            ['Pemeriksaan'], // Subjudul
            ['TB (cm)', $pemeriksaan['tb'] ?? '-'],
            ['BB (kg)', $pemeriksaan['bb'] ?? '-'],
            ['Suhu (°C)', $pemeriksaan['suhu'] ?? '-'],
            ['Tensi (mmHg)', $pemeriksaan['tensi'] ?? '-'],
            ['Nadi (bpm)', $pemeriksaan['nadi'] ?? '-'],
            ['Pernafasan (x/menit)', $pemeriksaan['pernafasan'] ?? '-'],

            [''], // Baris Kosong
            ['Detail Obat'], // Subjudul
            ['Obat', 'PCS', 'Satuan'],
            ...($terapi->obat->map(fn($obat) => [$obat->nama_obat, $obat->pivot->jumlah_obat, $obat->satuan])->toArray() ?: [['Tidak ada obat', '', '']])
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Format Judul Utama
        $sheet->mergeCells('A1:I1');
        $sheet->getStyle('A1')->applyFromArray([
            'font' => ['bold' => true, 'size' => 14],
            'alignment' => ['horizontal' => 'center'],
        ]);

        // Format Subjudul agar lebih jelas
        $sheet->getStyle('A6')->applyFromArray(['font' => ['bold' => true]]);
        $sheet->getStyle('A10')->applyFromArray(['font' => ['bold' => true]]);
        $sheet->getStyle('A18')->applyFromArray(['font' => ['bold' => true]]);
    }
}
