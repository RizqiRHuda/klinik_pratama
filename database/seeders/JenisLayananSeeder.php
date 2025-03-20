<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JenisLayananSeeder extends Seeder
{
    /**
     * Run the database seeds.
    */
    public function run(): void
    {
        DB::table('jenis_layanan')->insert([
            ['nama' => 'rujuk', 'deskripsi' => 'Pasien dirujuk ke rumah sakit lain.'],
            ['nama' => 'rawat_jalan', 'deskripsi' => 'Pasien dirawat tanpa rawat inap.']
           
        ]);
    }
}
