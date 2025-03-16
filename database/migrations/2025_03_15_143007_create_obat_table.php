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
        Schema::create('obat', function (Blueprint $table) {
            $table->id();
            $table->string('nama_obat')->unique();
            $table->integer('stock_awal');
            $table->integer('pemakaian');
            $table->integer('pemasukan');
            $table->integer('stock_akhir')->nullable();
            $table->integer('min_stock');
            $table->string('status_stock')->nullable();
            $table->string('satuan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('obat');
    }
};
