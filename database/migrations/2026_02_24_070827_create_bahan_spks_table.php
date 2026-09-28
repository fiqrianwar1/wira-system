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
        Schema::create('bahan_spks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('work_order_id')->constrained('work_orders')->onDelete('cascade');
            $table->foreignId('bahan_id')->constrained('bahans')->onDelete('cascade');
            $table->double('jumlah_pakai');
            $table->date('tanggal_pakai');
            $table->text('catatan')->nullable(); // Keterangan, misal: "Oplos Warna Merah Ferrari"
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bahan_spks');
    }
};
