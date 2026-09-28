<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'vehicle_id',
        'mechanic_id', 
        'nomor_spk',
        'status',
        'progress',    
        'repair_stage',
        'repair_type',
        'keluhan_customer',
        'tanggal_masuk',
        'estimasi_selesai',
        'estimasi_biaya',
        'diskon', // <--- INI BIANG KEROKNYA WKWK, WAJIB DITAMBAHIN!
        'foto_sebelum',
        'foto_sesudah',
    ];

    public function vehicle() { return $this->belongsTo(Vehicle::class); }
    public function mechanic() { return $this->belongsTo(Mechanic::class, 'mechanic_id'); }
    public function details() { return $this->hasMany(WorkOrderDetail::class); }
    public function allocations() { return $this->hasMany(WorkOrderAllocation::class); }
    public function attendances() { return $this->hasMany(Attendance::class); }
    public function bahanSpks() { return $this->hasMany(BahanSpk::class, 'work_order_id'); }
    public function complaints(){ return $this->hasMany(Complaint::class, 'work_order_id'); }
}