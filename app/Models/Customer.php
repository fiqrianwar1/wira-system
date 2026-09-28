<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    // Kolom yang boleh diisi
    protected $fillable = [
        'name',
        'phone',
        'address',
        'email',
    ];

    // Relasi: Satu Customer punya BANYAK Mobil (One to Many)
    public function vehicles()
    {
        return $this->hasMany(Vehicle::class);
    }
}