<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Nama tabel yang bener (walaupun 'users' udah default)
     */
    protected $table = 'users';
    public $timestamps = false;

    /**
     * Kolom yang boleh diisi.
     */
    protected $fillable = [
        'username',  // <-- Pastiin ada
        'fullname',  // <-- Pastiin ada
        'email',
        'password',
        'role',          // <-- Pastiin ada
        'signature_url', // <-- Pastiin ada
    ];

    /**
     * Kolom yang disembunyiin (penting buat keamanan).
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];
}
