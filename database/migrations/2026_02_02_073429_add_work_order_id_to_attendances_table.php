<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // KITA BIKIN TABEL BARU KHUSUS BUAT NYIMPEN JOB-NYA
        Schema::create('attendance_details', function (Blueprint $table) {
            $table->id();
            
            // Link ke tabel absensi utama (Si Ujang Hari Ini)
            // cascadeOnDelete biar kalo absennya dihapus, job-nya ikut kehapus bersih
            $table->foreignId('attendance_id')->constrained('attendances')->cascadeOnDelete();
            
            // Link ke SPK (Mobil apa yang dikerjain)
            $table->foreignId('work_order_id')->constrained('work_orders');
            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('attendance_details');
    }
};