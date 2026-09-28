<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            // Relasi ke Mekanik
            $table->foreignId('mechanic_id')->constrained('mechanics')->onDelete('cascade');
            
            $table->date('date'); // Tanggal Absen
            $table->enum('status', ['Hadir', 'Sakit', 'Ijin', 'Alpha'])->default('Hadir');
            
            // KOLOM PENTING: Unit yang dikerjakan hari itu
            $table->string('work_unit')->nullable(); 
            
            $table->string('note')->nullable(); // Keterangan tambahan
            $table->timestamps();

            // Mencegah double absen di tanggal & orang yang sama
            $table->unique(['mechanic_id', 'date']); 
        });
    }

    public function down()
    {
        Schema::dropIfExists('attendances');
    }
};