<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchedulesTfp extends Model
{
    use HasFactory;

    // Nama tabel di database
    protected $table = 'schedules_tfp';

    // Tabel ini TIDAK punya created_at/updated_at
    public $timestamps = false;

    // Biar gampang isi data nanti
    protected $guarded = [];

    // Cast tanggal
    protected $casts = [
        'tanggal' => 'date',
    ];
}