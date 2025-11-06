<?php

// app/Models/Personal.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Personal extends Model
{
    use HasFactory;

    // Izinkan pengisian massal untuk kolom ini
    protected $fillable = [
        'nik', 'nama', 'kelamin', 'jabatan', 'level_jabatan', 'lokasi', 'lokasi_induk'
    ];

    // Definisikan relasi: Satu Personal memiliki banyak WorkOrder
    public function workOrders()
    {
        return $this->hasMany(WorkOrder::class)->orderBy('tanggal', 'desc');
    }
}
