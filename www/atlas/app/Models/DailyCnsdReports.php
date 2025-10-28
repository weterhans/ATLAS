<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailyCnsdReports extends Model
{
    use HasFactory;

    // Nama tabel di database
    protected $table = 'daily_cnsd_reports';

    // Bilang ke Laravel nggak usah ngurusin created_at/updated_at
    public $timestamps = false;

    // Kolom apa aja yang boleh diisi (jika nanti pakai create/update)
    // protected $fillable = [ 'report_id_custom', 'dinas', ... ];
    // Atau cara gampang:
    protected $guarded = [];

    // Kalo ada kolom JSON
    protected $casts = [
        'equipment_status' => 'array',
        'tanggal' => 'date'
    ];
}
