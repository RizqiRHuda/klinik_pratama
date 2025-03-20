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
        Schema::create('terapi_obat', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_terapi')->constrained('terapi')->onDelete('cascade');
            $table->foreignId('id_obat')->constrained('obat')->onDelete('cascade');
            $table->integer('jumlah_obat');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('terapi_obat');
    }
};
