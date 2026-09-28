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
        Schema::create('work_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vehicle_id')->constrained()->onDelete('cascade');
            $table->string('nomor_spk')->unique();
            $table->string('status'); // pending, proses, selesai
            
            // TAMBAHIN INI BRO:
            $table->string('repair_type')->default('Regular'); // Regular / Quick Repair
            
            $table->text('keluhan_customer')->nullable();
            $table->date('tanggal_masuk');
            $table->date('estimasi_selesai')->nullable();
            $table->decimal('estimasi_biaya', 15, 2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('work_orders');
    }
};
