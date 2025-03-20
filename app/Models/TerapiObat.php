<?php

namespace App\Models;

use App\Models\Obat;
use App\Models\Terapi;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TerapiObat extends Model
{
    use HasFactory;

    protected $table = 'terapi_obat';

    protected $fillable = [
        'id_terapi',
        'id_obat',
        'jumlah_obat',
    ];

    public function terapi()
    {
        return $this->belongsTo(Terapi::class, 'id_terapi');
    }

    public function obat()
    {
        return $this->belongsTo(Obat::class, 'id_obat');
    }
}
