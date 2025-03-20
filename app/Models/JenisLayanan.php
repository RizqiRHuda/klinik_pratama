<?php

namespace App\Models;

use App\Models\Terapi;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class JenisLayanan extends Model
{
    use HasFactory;

    protected $table = "jenis_layanan";
    protected $fillable = ['nama', 'deskripsi'];

    public function terapi()
    {
        return $this->hasMany(Terapi::class, 'id_jenis_layanan');
    }
}
