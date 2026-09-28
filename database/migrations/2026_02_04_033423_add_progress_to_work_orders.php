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
        Schema::table('work_orders', function (Blueprint $table) {
            // Cek dulu biar gak error "Column already exists"
            if (!Schema::hasColumn('work_orders', 'progress')) {
                $table->integer('progress')->default(0)->after('status');
            }
            if (!Schema::hasColumn('work_orders', 'mechanic_id')) {
                $table->foreignId('mechanic_id')->nullable()->after('vehicle_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('work_orders', function (Blueprint $table) {
            //
        });
    }
};
