<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('work_order_details', function (Blueprint $table) {
            // Kita ubah jadi NULLABLE biar bisa simpan stok tanpa nomor SPK
            $table->unsignedBigInteger('work_order_id')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('work_order_details', function (Blueprint $table) {
            // Balikin lagi jadi wajib isi (kalau di-rollback)
            $table->unsignedBigInteger('work_order_id')->nullable(false)->change();
        });
    }
};