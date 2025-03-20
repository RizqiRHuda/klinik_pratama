<?php
namespace App\Models;

use App\Models\Terapi;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pasien extends Model
{
    use HasFactory;
    protected $table = 'pasien';

    protected $fillable = [
        'no_rm',
        'nama_pasien',
        'nik',
        'alamat',
        'no_hp',
        'tgl_lahir',
        'jk',
        'pekerjaan',
        'riwayat_alergi',
    ];

    /**
     * Format tanggal lahir saat diambil
     */
    public function getTglLahirAttribute($value)
    {
        return Carbon::parse($value)->format('Y-m-d'); // Format menjadi YYYY-MM-DD
    }

    public function terapi()
    {
        return $this->hasMany(Terapi::class, 'id_pasien');
    }
}
