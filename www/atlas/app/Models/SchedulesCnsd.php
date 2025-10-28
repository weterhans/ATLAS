<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchedulesCnsd extends Model
{
    use HasFactory;

    /**
     * Tambahin baris ini
     * Kasih tau Laravel nama tabel yang bener
     */
    protected $table = 'schedules_cnsd';

    // Pastiin ini juga ada (biar nggak error updated_at)
    public $timestamps = false;

    // Biar gampang isi data nanti
    protected $guarded = [];

    // Cast tanggal biar jadi objek Carbon
    protected $casts = [
        'tanggal' => 'date',
    ];
}