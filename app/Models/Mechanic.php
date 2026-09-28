<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mechanic extends Model
{
    use HasFactory;

    // Tambahkan 'phone' disini bro
    protected $fillable = [
        'name', 
        'phone', 
        'position', 
        'specialist', 
        'is_active' // <--- INI WAJIB ADA BIAR BISA DISAVE KE DATABASE
    ];

    // Relasi ke Absensi
    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    public function allocations()
    {
        // 1 Mekanik punya banyak (hasMany) Alokasi Pekerjaan
        return $this->hasMany(WorkOrderAllocation::class, 'mechanic_id', 'id');
    }
}