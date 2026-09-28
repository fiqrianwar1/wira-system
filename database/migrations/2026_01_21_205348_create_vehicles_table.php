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
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained()->cascadeOnDelete();
            $table->string('nopol')->unique();
            $table->string('merk');       // Contoh: Toyota
            $table->string('model');      // Contoh: Avanza Veloz
            $table->string('warna');      // Contoh: Silver Metallic
            $table->string('tahun')->nullable();      // <--- Tambahan
            $table->string('no_rangka')->nullable();  // Frame No
            $table->string('no_mesin')->nullable();   // <--- Tambahan (Engine No)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};
