<?php
namespace App\Imports;

use App\Models\Obat;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ObatImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {

        $data = $this->mapColumns($row);

        if (! $data) {
            return null;
        }

        $data['stock_akhir']  = ($data['stock_awal'] - $data['pemakaian']) + $data['pemasukan'];
        $data['status_stock'] = $data['stock_akhir'] <= $data['min_stock'] ? 'Kurang' : 'Cukup';

        // Gunakan updateOrCreate untuk menghindari duplikasi
        Obat::updateOrCreate(
            ['nama_obat' => $data['nama_obat']],
            $data
        );
    }

    private function mapColumns($row)
    {

        unset($row['stock_akhir']);
        $headerMapping = [
            'nama_obat'  => ['nama_obat', 'Nama Obat', 'obat_nama', 'nama'],
            'stock_awal' => ['stock_awal', 'Stock Awal', 'stok_awal', 'jumlah_awal'],
            'pemakaian'  => ['pemakaian', 'Pemakaian', 'digunakan', 'jumlah_pakai'],
            'pemasukan'  => ['pemasukan', 'Pemasukan', 'diterima', 'jumlah_masuk'],
            'min_stock'  => ['min_stock', 'Min Stock', 'stok_minimal', 'stok_min'],
            'satuan'     => ['satuan', 'Satuan', 'unit', 'jenis_satuan'],
        ];

        $mapHeader = function ($possibleKeys) use ($row) {
            foreach ($possibleKeys as $key) {
                if (isset($row[$key])) {
                    return $row[$key];
                }
            }
            return null;
        };

        $nama_obat  = $mapHeader($headerMapping['nama_obat']);
        $stock_awal = $mapHeader($headerMapping['stock_awal']);
        $pemakaian  = $mapHeader($headerMapping['pemakaian']) ?? 0; // Default 0 jika kosong
        $pemasukan  = $mapHeader($headerMapping['pemasukan']) ?? 0; // Default 0 jika kosong
        $min_stock  = $mapHeader($headerMapping['min_stock']);
        $satuan     = $mapHeader($headerMapping['satuan']);

        if (! $nama_obat || ! $stock_awal || ! $pemakaian || ! $pemasukan || ! $min_stock || ! $satuan) {
            return null;
        }

        return compact('nama_obat', 'stock_awal', 'pemakaian', 'pemasukan', 'min_stock', 'satuan');
    }
}
