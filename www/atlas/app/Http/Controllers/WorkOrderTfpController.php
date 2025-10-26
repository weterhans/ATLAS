<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WorkOrderTfpController extends Controller
{
    /**
     * Menampilkan halaman daftar Work Order TFP.
     */
    public function index()
    {
        // Data Dummy untuk TFP
        $workOrders = [
            (object)[
                'wo_number' => 'WO-TFP-0004',
                'tanggal'   => '2025-10-25',
                'deskripsi' => 'Kalibrasi peralatan Glide Path',
                'status'    => 'Baru'
            ],
            (object)[
                'wo_number' => 'WO-TFP-0003',
                'tanggal'   => '2025-10-24',
                'deskripsi' => 'Pemeriksaan antena Localizer',
                'status'    => 'Selesai'
            ],
        ];

        // Arahkan ke view TFP yang akan kita buat
        return view('work-orders.tfp.index', ['workOrders' => $workOrders]);
    }
}
