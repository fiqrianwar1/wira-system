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
        Schema::create('bahans', function (Blueprint $table) {
            $table->id();
            $table->string('kode_bahan')->unique(); // Misal: BHN-001
            $table->string('nama_bahan'); // Misal: Clear Coat Belkote, Thinner PU
            $table->string('kategori'); // Cat, Thinner, Clear, Dempul, Epoxy, Amplas
            $table->double('stok')->default(0); // Pakai double biar bisa 1.5 Liter
            $table->string('satuan'); // Liter, Kg, Gram, Set, Pcs
            $table->integer('harga_satuan')->default(0); // Buat ngitung modal (HPP) per mobil
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bahans');
    }
};
