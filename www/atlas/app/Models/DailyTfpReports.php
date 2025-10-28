<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailyTfpReports extends Model
{
    use HasFactory;

    // Nama tabel di database
    protected $table = 'daily_tfp_reports';

    // Tabel ini punya created_at/updated_at
    // Jadi, JANGAN tambahin 'public $timestamps = false;'

    // Biar gampang isi data
    protected $guarded = [];

    // Kolom JSON
    protected $casts = [
        'equipment_status' => 'array',
        'tanggal' => 'date',
    ];
}