<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WorkOrderCnsdController extends Controller
{
    /**
     * Menampilkan halaman daftar Work Order CNSD.
     */
    public function index()
    {
        // Data Dummy - Ganti ini dengan data dari database Anda nanti
        $workOrders = [
            (object)[
                'wo_number' => 'WO-CNSD-0002',
                'tanggal'   => '2025-10-21',
                'deskripsi' => 'Perbaikan sistem ILS runway 28',
                'status'    => 'Baru'
            ],
            (object)[
                'wo_number' => 'WO-CNSD-0001',
                'tanggal'   => '2025-10-20',
                'deskripsi' => 'Pengecekan rutin perangkat DVOR',
                'status'    => 'Baru'
            ],
        ];

        // Mengirim data ke view
        return view('work-orders.cnsd.index', ['workOrders' => $workOrders]);
    }
}
