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
        Schema::create('terapi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_pasien')->constrained('pasien')->onDelete('cascade');
            $table->date('tgl_terapi');
            $table->text('anamnesa');
            $table->json('pemeriksaan'); // Menyimpan JSON (tb, bb, suhu, dll.)
            $table->text('diagnosa');
            $table->text('pengobatan')->nullable();
            $table->string('tindakan')->nullable();
            $table->foreignId('id_jenis_layanan')->constrained('jenis_layanan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('terapi');
    }
};
