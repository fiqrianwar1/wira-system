<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;

    // INI DIA BIANG KEROKNYA! TAMBAHIN KOLOM YANG ILANG DI SINI
    protected $fillable = [
        'customer_id',
        'nopol',
        'merk',
        'model',
        'warna',
        'tahun',       // <--- JANGAN LUPA INI
        'no_rangka',   
        'no_mesin',    // <--- SAMA INI
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function workOrders()
    {
        return $this->hasMany(WorkOrder::class);
    }
}