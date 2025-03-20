<?php
namespace App\Models;

use App\Models\TerapiObat;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Obat extends Model
{
    use HasFactory;

    protected $table = "obat";

    protected $fillable = [
        'nama_obat', 
        'stock_awal', 
        'pemakaian', 
        'pemasukan', 
        'stock_akhir', 
        'min_stock', 
        'status_stock', 
        'satuan',
    ];

    protected static function boot()
    {
        parent::boot();
        static::saving(function ($obat) {
            $obat->status_stock = ($obat->stock_akhir >= $obat->min_stock) ? 'Aman' : 'Tidak Aman';
        });
    }

    public function updateStock()
    {
        $this->stock_akhir = $this->stock_awal - $this->pemakaian + $this->pemasukan;
        $this->save();
    }

    public function terapiObat()
    {
        return $this->hasMany(TerapiObat::class, 'id_obat');
    }

    public function decreaseStock($jumlah)
    {
        // Pastikan jumlah yang dikurangi tidak melebihi stok yang tersedia
        if ($this->stock_akhir >= $jumlah) {
            $this->stock_akhir -= $jumlah;
            $this->save();
        } else {
            throw new \Exception('Stok obat tidak mencukupi.');
        }
    }
}
