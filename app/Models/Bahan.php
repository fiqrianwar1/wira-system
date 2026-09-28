<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bahan extends Model
{
    use HasFactory;

    // INI JURUS SAKTINYA BRO! 
    // Biar semua kolom (termasuk kode_bahan & supplier & nomor_nota) dapet izin buat disave/diupdate
    protected $guarded = []; 

    // Relasi: Satu Bahan bisa dipakai di banyak SPK
    public function penggunanSpk()
    {
        return $this->hasMany(BahanSpk::class, 'bahan_id');
    }
}