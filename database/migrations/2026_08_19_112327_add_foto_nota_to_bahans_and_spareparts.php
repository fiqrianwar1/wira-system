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
    // Tambah di tabel bahans
    Schema::table('bahans', function (Blueprint $table) {
        $table->string('foto_nota')->nullable()->after('nomor_nota');
    });

    // Tambah di tabel work_order_details (karena stok manual sparepart pakai tabel ini)
    Schema::table('work_order_details', function (Blueprint $table) {
        $table->string('foto_nota')->nullable()->after('part_eta');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bahans_and_spareparts', function (Blueprint $table) {
            //
        });
    }
};
