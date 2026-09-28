<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // 1. TABEL HEADERS PO (TRANSAKSI)
        Schema::create('purchase_orders', function (Blueprint $table) {
            $table->id();
            $table->string('po_number')->unique(); // Contoh: PO-202602-001
            $table->string('supplier_name');       // Nama Toko/TAM
            $table->date('order_date');            // Tanggal Order
            $table->enum('status', ['Draft', 'Ordered', 'Received', 'Canceled'])->default('Draft');
            $table->decimal('total_amount', 15, 2)->default(0); // Total Duit
            $table->text('notes')->nullable();     // Catatan tambahan
            $table->timestamps();
        });

        // 2. TABEL ITEM PO (DETAIL BARANG)
        Schema::create('purchase_order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('purchase_order_id')->constrained()->onDelete('cascade');
            
            // Link ke SPK (Boleh Null kalo buat stok gudang biasa)
            // Ini ngambil dari tabel detail SPK yang udah ada
            $table->unsignedBigInteger('work_order_detail_id')->nullable();
            
            $table->string('item_name'); // Nama Panel/Sparepart
            $table->integer('qty');
            $table->decimal('price', 15, 2)->default(0); // Harga Beli Satuan
            $table->decimal('subtotal', 15, 2)->default(0);
            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('purchase_order_items');
        Schema::dropIfExists('purchase_orders');
    }
};