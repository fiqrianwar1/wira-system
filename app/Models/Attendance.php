<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'mechanic_id',
        'date',
        'status',
        'work_order_id', // <--- GANTI work_unit JADI INI
        'note',
    ];

    public function mechanic()
    {
        return $this->belongsTo(Mechanic::class);
    }

    // Relasi ke SPK
    public function details()
    {
        return $this->hasMany(AttendanceDetail::class, 'attendance_id');
    }
}