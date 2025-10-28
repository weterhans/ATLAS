<?php

namespace App\Http\Controllers;

// 1. Pastikan Model-nya di-'use'
use App\Models\SaveDataTfp; // <-- Pake Model TFP Save Data
use Illuminate\Http\Request;

class SaveDataTfpController extends Controller
{
    /**
     * Tampilkan halaman save data TFP.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // 2. Ambil data, urutkan, kelompokkan per tanggal
        $savedData = SaveDataTfp::orderBy('tanggal', 'desc')->get();
        $groupedData = $savedData->groupBy(function ($item) {
            return \Carbon\Carbon::parse($item->tanggal)->format('Y-m-d');
        });

        // 3. Kirim data ke view 'tfp.save_data'
        return view('tfp.save_data', [
            'groupedData' => $groupedData
        ]);
    }
}