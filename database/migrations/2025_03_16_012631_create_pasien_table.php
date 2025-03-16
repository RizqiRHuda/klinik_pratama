<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pasien', function (Blueprint $table) {
            $table->id();
            $table->string('no_rm')->unique();
            $table->string('nama_pasien');
            $table->string('nik')->unique();
            $table->text('alamat');
            $table->string('no_hp')->nullable();
            $table->date('tgl_lahir');
            $table->enum('jk', ['L', 'P']);
            $table->string('pekerjaan')->nullable();
            $table->text('riwayat_alergi')->nullable(); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pasien');
    }
};
