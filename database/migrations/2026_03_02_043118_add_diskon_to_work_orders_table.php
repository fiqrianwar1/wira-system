<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('work_orders', function (Blueprint $table) {
            // Kita tambahin kolom diskon setelah estimasi_biaya
            // Tipenya integer aja (buat persenan 0-100), default kasih 0
            $table->integer('diskon')->default(0)->after('estimasi_biaya');
        });
    }

    public function down(): void
    {
        Schema::table('work_orders', function (Blueprint $table) {
            $table->dropColumn('diskon');
        });
    }
};
