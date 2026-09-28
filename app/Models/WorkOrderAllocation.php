<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkOrderAllocation extends Model
{
    use HasFactory;
    
    // Update fillable dengan kolom waktu baru
    protected $fillable = ['work_order_id', 'mechanic_id', 'stage', 'start_time', 'end_time'];

    // Relasi balik ke SPK
    public function workOrder()
    {
        return $this->belongsTo(WorkOrder::class, 'work_order_id', 'id');
    }

    // Relasi balik ke Mekanik
    public function mechanic()
    {
        return $this->belongsTo(Mechanic::class, 'mechanic_id', 'id');
    }
}