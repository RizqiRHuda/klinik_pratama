<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
