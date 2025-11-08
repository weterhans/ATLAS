<?php

namespace App\Http\Controllers;

use App\Models\Personal;
use App\Models\WorkOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PersonalController extends Controller
{
    // Mengambil data dari DB lokal
    public function index()
    {
        $personals = Personal::orderBy('level_jabatan', 'desc')->get();
        return view('personal', ['personals' => $personals]);
    }

    // Menambah staf ke DB lokal
    public function store(Request $request)
    {
        // MODIFIKASI: Menghapus 'pernium'
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
        return response()->json($personal);
    }

    // Menghapus staf dari DB lokal
    public function destroy(Personal $personal)
    {
        $personal->delete();
        return response()->json(['message' => 'Staf berhasil dihapus']);
    }

    // Logika untuk Sinkronisasi GSheet
    public function syncFromGoogleSheet()
    {
        $url = 'https://docs.google.com/spreadsheets/d/e/2PACX-1vTTgyK8hLDZajIXckdGcBuV9W4zVgT_QGqVK7irDc0fqPUNHgpxai2X9Pk6vj5qz22xBozTruWkWx8z/pub?output=csv';
        $updatedCount = 0;
        $createdCount = 0;

        try {
            $response = Http::get($url);

            if ($response->successful()) {
                $csvData = $response->body();
                $rows = array_map('str_getcsv', explode("\n", $csvData));
                $header = array_map('trim', array_shift($rows));

                // MODIFIKASI: Hanya mapping NIK (dari GSheet 'id')
                $nikCol = array_search('id', $header); // GSheet 'id' -> DB 'nik'
                $namaCol = array_search('Nama', $header);
                $kelaminCol = array_search('Kelamin', $header);
                $jabatanCol = array_search('Jabatan', $header);
                $levelCol = array_search('Level Jabatan', $header);
                $lokasiCol = array_search('Lokasi', $header);
                $lokasiIndukCol = array_search('Lokasi Induk', $header);

                if ($nikCol === false || $namaCol === false) {
                    throw new \Exception('Kolom GSheet (id/Nama) tidak ditemukan.');
                }

                foreach ($rows as $row) {
                    if (count($row) === count($header) && !empty($row[$nikCol])) {
                        // MODIFIKASI: Menghapus 'pernium'
                        $data = [
                            'nama' => $row[$namaCol],
                            'kelamin' => $row[$kelaminCol] ?? 'L',
                            'jabatan' => $row[$jabatanCol] ?? 'N/A',
                            'level_jabatan' => $row[$levelCol] ?? '0',
                            'lokasi' => $row[$lokasiCol] ?? 'Cabang Surabaya',
                            'lokasi_induk' => $row[$lokasiIndukCol] ?? 'Surabaya',
                        ];

                        $personal = Personal::where('nik', $row[$nikCol])->first();

                        if ($personal) {
                            $personal->update($data);
                            $updatedCount++;
                        } else {
                            $data['nik'] = $row[$nikCol]; // Tambahkan NIK
                            Personal::create($data);
                            $createdCount++;
                        }
                    }
                }

                return response()->json([
                    'message' => "Sinkronisasi Selesai. $updatedCount data diperbarui, $createdCount data baru."
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Gagal sinkronisasi GSheet: ' . $e->getMessage());
            return response()->json(['message' => 'Gagal mengambil data dari Google Sheet.'], 500);
        }
    }


    // --- FUNGSI WORK ORDER TETAP SAMA ---

    public function getWorkOrders(Personal $personal)
    {
        $workOrders = $personal->workOrders;
        return response()->json($workOrders);
    }

    public function storeWorkOrder(Request $request, Personal $personal)
    {
        $data = $request->validate([
            'tanggal' => 'required|date',
            'fasilitas' => 'required|string',
            'jenis' => 'required|string',
            'deskripsi' => 'nullable|string',
            'pelaksana_tipe' => 'required|string',
            'pelaksana_nama' => 'nullable|string',
            'pelaksana_group' => 'nullable|string',
        ]);

        $workOrder = $personal->workOrders()->create($data);

        return response()->json($workOrder);
    }

    public function destroyWorkOrder(WorkOrder $workOrder)
    {
        $workOrder->delete();
        return response()->json(['message' => 'Work Order berhasil dihapus']);
    }
}
