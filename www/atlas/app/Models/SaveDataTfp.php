<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaveDataTfp extends Model
{
    use HasFactory;

    // Nama tabel di database
    protected $table = 'tfp_savedata';

    // Tabel ini TIDAK punya created_at/updated_at
    public $timestamps = false;

    // Biar gampang isi data
    protected $guarded = [];

    // Cast tanggal
    protected $casts = [
        'tanggal' => 'date',
        'sampai' => 'date',
    ];
}