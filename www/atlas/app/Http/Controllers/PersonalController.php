<?php

// app/Http/Controllers/PersonalController.php
namespace App\Http\Controllers;

use App\Models\Personal;
use App\Models\WorkOrder;
use Illuminate\Http\Request;

class PersonalController extends Controller
{
    // Tampilkan halaman Data Personal
    public function index()
    {
        // Ambil semua data personal, diurutkan berdasarkan level
        $personals = Personal::orderBy('level_jabatan', 'desc')->get();

        // Kirim data ke view
        return view('personal', ['personals' => $personals]);
    }

    // Tambah Staf Baru
    public function store(Request $request)
    {
        $data = $request->validate([
            'nik' => 'required|string|unique:personals,nik',
            'nama' => 'required|string',
            'kelamin' => 'required|string|max:1',
            'jabatan' => 'required|string',
            'level_jabatan' => 'required|string',
            'lokasi' => 'required|string',
            'lokasi_induk' => 'required|string',
        ]);

        $personal = Personal::create($data);

        // Kembalikan data baru sebagai JSON
        return response()->json($personal);
    }

    // Hapus Staf
    public function destroy(Personal $personal)
    {
        $personal->delete();
        return response()->json(['message' => 'Staf berhasil dihapus']);
    }

    // Ambil Work Order milik Staf
    public function getWorkOrders(Personal $personal)
    {
        // Kita gunakan relasi yang sudah dibuat
        $workOrders = $personal->workOrders;
        return response()->json($workOrders);
    }

    // Simpan Work Order baru untuk Staf
    public function storeWorkOrder(Request $request, Personal $personal)
    {
        $data = $request->validate([
            'tanggal' => 'required|date',
            'fasilitas' => 'required|string',
            'jenis' => 'required|string',
            'deskripsi' => 'nullable|string',
        ]);

        // Buat Work Order baru yang terhubung dengan $personal
        $workOrder = $personal->workOrders()->create($data);

        return response()->json($workOrder);
    }

    // Hapus Work Order
    public function destroyWorkOrder(WorkOrder $workOrder)
    {
        $workOrder->delete();
        return response()->json(['message' => 'Work Order berhasil dihapus']);
    }
}
