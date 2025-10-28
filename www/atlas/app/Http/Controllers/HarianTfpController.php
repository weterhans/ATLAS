<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HarianTfpController extends Controller
{
    /**
     * Menampilkan halaman menu Harian TFP.
     */
    public function index()
    {
        // Nanti nama view-nya 'tfp.index'
        return view('tfp.index');
    }

    // Nanti kita bakal nambahin fungsi lain di sini:
    // public function jadwal() { ... }
    // public function daily() { ... }
    // public function kegiatan() { ... }
    // public function save() { ... }
}
