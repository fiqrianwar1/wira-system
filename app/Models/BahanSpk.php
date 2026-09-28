<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BahanSpk extends Model
{
    use HasFactory;
    protected $guarded = [];

    // Relasi balik ke WorkOrder (SPK)
    public function workOrder()
    {
        return $this->belongsTo(WorkOrder::class, 'work_order_id');
    }

    // Relasi balik ke Bahan
    public function bahan()
    {
        return $this->belongsTo(Bahan::class, 'bahan_id');
    }

    // Tambahin ini di bawah relasi yang udah ada
    public function mechanic()
    {
        // PENTING: Ganti Mechanic::class jadi model mekanik lu (misal User::class atau Employee::class)
        return $this->belongsTo(\App\Models\Mechanic::class, 'mechanic_id'); 
    }
}