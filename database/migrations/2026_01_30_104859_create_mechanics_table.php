<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        // KITA BIKIN TABEL BARU DARI NOL (CREATE)
        Schema::create('mechanics', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('position')->default('Teknisi'); // Jabatan
            $table->string('specialist')->nullable();
            $table->string('phone')->nullable(); // No HP
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        // KALAU ROLLBACK, HAPUS SATU TABEL FULL
        Schema::dropIfExists('mechanics');
    }
};