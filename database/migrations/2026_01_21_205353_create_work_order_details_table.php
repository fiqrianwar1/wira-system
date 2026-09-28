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
        Schema::create('work_order_details', function (Blueprint $table) {
            $table->id();
            // Relasi ke tabel work_orders
            $table->foreignId('work_order_id')->constrained('work_orders')->onDelete('cascade');
            
            // KOLOM INI YANG TADI HILANG/ERROR
            $table->string('panel_name'); 
            
            $table->string('kerusakan')->nullable();
            $table->string('part_status')->nullable()->default('Ready'); // Ready, Order, OTW
            $table->string('part_location')->nullable(); // Jakarta, Surabaya, dll
            $table->date('part_eta')->nullable(); // Estimasi Sampai
            $table->decimal('harga', 15, 2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('work_order_details');
    }
};
