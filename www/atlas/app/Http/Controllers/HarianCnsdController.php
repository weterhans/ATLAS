<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HarianCnsdController extends Controller
{
    /**
     * Menampilkan halaman menu Harian CNSD.
     */
    public function index()
    {
        // Nanti nama view-nya 'cnsd.index'
        return view('cnsd.index');
    }

    // Nanti kita bakal nambahin fungsi lain di sini:
    // public function jadwal() { ... }
    // public function daily() { ... }
    // public function kegiatan() { ... }
    // public function save() { ... }
}