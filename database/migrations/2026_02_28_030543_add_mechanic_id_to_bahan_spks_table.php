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
        Schema::table('bahan_spks', function (Blueprint $table) {
            // Sesuaikan 'mechanics' kalo nama tabel teknisi lu beda (misal: users atau employees)
            $table->foreignId('mechanic_id')->nullable()->constrained('mechanics');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bahan_spks', function (Blueprint $table) {
            //
        });
    }
};
