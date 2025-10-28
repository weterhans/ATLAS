<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CnsdActivities extends Model
{
    use HasFactory;

    // Nama tabel di database
    protected $table = 'cnsd_activities';

    // Tabel ini punya created_at/updated_at, jadi JANGAN pakai $timestamps = false;

    // Biar gampang isi data
    protected $guarded = [];

    // Kolom JSON & Tanggal
    protected $casts = [
        'teknisi' => 'array',
        'lampiran' => 'array',
        'tanggal' => 'date',
    ];
}
