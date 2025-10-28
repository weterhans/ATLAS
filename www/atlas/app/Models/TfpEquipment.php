<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TfpEquipment extends Model
{
    use HasFactory;
    protected $table = 'tfp_equipment'; // Nama tabel
    public $timestamps = false; // Gak ada created_at/updated_at
    protected $fillable = ['name'];
}