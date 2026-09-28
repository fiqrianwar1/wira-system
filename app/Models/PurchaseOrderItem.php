<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseOrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'purchase_order_id',
        'work_order_detail_id', // Ini kunci Hybrid-nya (Link ke SPK)
        'item_name',
        'qty',
        'price',
        'subtotal'
    ];

    // Relasi ke Header PO
    public function purchaseOrder()
    {
        return $this->belongsTo(PurchaseOrder::class);
    }

    // Relasi ke Detail SPK (Buat tau ini barang pesenan siapa)
    public function workOrderDetail()
    {
        return $this->belongsTo(WorkOrderDetail::class, 'work_order_detail_id');
    }
}