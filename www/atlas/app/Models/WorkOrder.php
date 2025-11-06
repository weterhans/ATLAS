<?php

// app/Models/WorkOrder.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkOrder extends Model
{
    use HasFactory;

    // Izinkan pengisian massal
    protected $fillable = [
        'personal_id', 'tanggal', 'fasilitas', 'jenis', 'deskripsi'
    ];

    // Opsional: Definisikan relasi sebaliknya
    public function personal()
    {
        return $this->belongsTo(Personal::class);
    }
}
