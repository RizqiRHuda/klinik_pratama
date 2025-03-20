<?php
namespace App\Models;

use App\Models\Obat;
use App\Models\Pasien;
use App\Models\JenisLayanan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Terapi extends Model
{
    use HasFactory;

    protected $table    = "terapi";
    protected $fillable = ['id_pasien', 'tgl_terapi', 'anamnesa', 'pemeriksaan', 'diagnosa', 'pengobatan', 'id_jenis_layanan'];

    protected $casts = [
        'pemeriksaan' => 'array', // Pastikan JSON diubah ke array saat diakses
    ];

    public function pasien()
    {
        return $this->belongsTo(Pasien::class, 'id_pasien');
    }

    public function jenisLayanan()
    {
        return $this->belongsTo(JenisLayanan::class, 'id_jenis_layanan');
    }

    // public function obat()
    // {
    //     return $this->hasMany(TerapiObat::class, 'id_terapi');
    // }
    public function obat()
{
    return $this->belongsToMany(Obat::class, 'terapi_obat', 'id_terapi', 'id_obat')
                ->withPivot('jumlah_obat');
}

  
}
