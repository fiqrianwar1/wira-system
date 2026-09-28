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
        Schema::create('complaints', function (Blueprint $table) {
            $table->id();
            // Relasi ke tabel SPK (WorkOrder), karena komplain pasti butuh data SPK lama
            $table->foreignId('work_order_id')->constrained('work_orders')->onDelete('cascade');
            $table->text('keluhan'); // Deskripsi dari customer (misal: cat belang, bintik)
            $table->string('foto_bukti'); // Path foto yg diupload
            $table->enum('status', ['menunggu', 'disetujui', 'ditolak'])->default('menunggu');
            $table->text('catatan_sa')->nullable(); // Alasan SA menolak/menyetujui
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('complaints');
    }
};
