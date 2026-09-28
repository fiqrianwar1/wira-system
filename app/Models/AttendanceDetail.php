<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttendanceDetail extends Model
{
    use HasFactory;
    
    // Ini biar bisa diisi massal
    protected $guarded = ['id'];

    // Relasi balik ke SPK (Biar tau ini mobil apa)
    public function workOrder()
    {
        return $this->belongsTo(WorkOrder::class, 'work_order_id');
    }
}