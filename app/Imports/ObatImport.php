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
        $nama_obat  = $row['nama_obat'] ?? $row['nama'] ?? $row['obat_nama'] ?? null;
        $stock_awal = $row['stock_awal'] ?? $row['stok_awal'] ?? $row['jumlah_awal'] ?? null;
        $pemakaian  = $row['pemakaian'] ?? $row['digunakan'] ?? $row['jumlah_pakai'] ?? null;
        $pemasukan  = $row['pemasukan'] ?? $row['diterima'] ?? $row['jumlah_masuk'] ?? null;
        $min_stock  = $row['min_stock'] ?? $row['stok_minimal'] ?? $row['stok_min'] ?? null;
        $satuan     = $row['satuan'] ?? $row['unit'] ?? $row['jenis_satuan'] ?? null;

       
        if (! $nama_obat || ! $stock_awal || ! $pemakaian || ! $pemasukan || ! $min_stock || ! $satuan) {
            return null;
        }

        return compact('nama_obat', 'stock_awal', 'pemakaian', 'pemasukan', 'min_stock', 'satuan');
    }
}
