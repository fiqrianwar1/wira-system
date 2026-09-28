<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'work_order_id', // <--- INI WAJIB DITAMBAH
        'po_number', 
        'supplier_name', 
        'order_date', 
        'status', 
        'notes', 
        'total_amount'
    ];

    /**
     * FIX ERROR: format() on string
     * Kita kasih tau Laravel kalau kolom ini adalah Date.
     */
    protected $casts = [
        'order_date' => 'date',
    ];

    // Relasi: Satu PO punya banyak Item Barang
    public function items()
    {
        return $this->hasMany(PurchaseOrderItem::class);
    }

    public function workOrder()
    {
        return $this->belongsTo(WorkOrder::class, 'work_order_id');
    }
}