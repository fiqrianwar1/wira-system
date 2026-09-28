<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkOrderDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'work_order_id',
        'panel_name',
        'kerusakan',
        'harga',
        // --- KOLOM BARU BUAT ORANG GUDANG ---
        'part_status',   // 'Ready', 'Order', 'OTW'
        'part_location', // Nama Toko / Supplier
        'part_eta',      // Estimasi Tanggal Sampai / Tgl Tiba
        'foto_nota'
    ];

    public function workOrder()
    {
        return $this->belongsTo(WorkOrder::class);
    }
}