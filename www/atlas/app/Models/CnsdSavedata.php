<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CnsdSavedata extends Model
{
    use HasFactory;

    // Nama tabel di database
    protected $table = 'cnsd_savedata';

    // Tabel ini TIDAK punya created_at/updated_at
    public $timestamps = false;

    // Biar gampang isi data (kalau nanti pakai create/update)
    protected $guarded = [];

    // Pastikan kolom tanggal di-cast jadi objek Carbon
    protected $casts = [
        'tanggal' => 'date',
        'sampai' => 'date', // Jika kolom 'sampai' juga dipakai
    ];
}
