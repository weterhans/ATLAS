<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

class ScheduleController extends Controller
{
    public function getScheduleData()
    {
        // Ganti dengan URL CSV dari Google Sheet Anda (hasil publish to web)
        $googleSheetUrl = 'https://docs.google.com/spreadsheets/d/e/2PACX-1vTTgyK8hLDZajIXckdGcBuV9W4zVgT_QGqVK7irDc0fqPUNHgpxai2X9Pk6vj5qz22xBozTruWkWx8z/pub?output=csv';

        try {
            $response = Http::get($googleSheetUrl);

            if ($response->failed()) {
                return response()->json(['error' => 'Gagal mengambil data dari Google Sheet.'], 500);
            }

            $csvData = $response->body();
            $allRows = str_getcsv($csvData, "\n"); // Pisahkan per baris
            array_shift($allRows); // Hapus baris header

            // 1. Pembersihan Data (Mirip .filter di JS)
            $cleanedRows = [];
            foreach ($allRows as $rowStr) {
                $row = str_getcsv($rowStr, ",");
                // Cek kondisi: harus array, punya > 3 kolom, nama (indeks 1) dan jabatan (indeks 3) tidak kosong
                if (is_array($row) && count($row) > 3 && !empty(trim($row[1] ?? '')) && !empty(trim($row[3] ?? ''))) {
                    $cleanedRows[] = $row;
                }
            }

            // 2. Setup tanggal & kolom
            $today = Carbon::now('Asia/Jakarta');
            $displayDate = $today->translatedFormat('l, d F Y'); // Format: Senin, 27 Oktober 2025
            $todayDate = $today->day;
            $offsetColumns = 4; // Kolom: NO, NAMA, KELAS JABATAN, JABATAN
            $columnIndexForToday = $offsetColumns + $todayDate - 1;

            $ketColumnIndex = 35;

            // 3. Kamus shift
            $shiftDictionary = ['P' => 'PAGI', 'S' => 'SIANG', 'M' => 'MALAM'];

            // 4. Wadah Kategori
            $managerSchedule = [];
            $cnsSchedule = [];
            $tfpSchedule = [];

            // 5. Proses dan kategorikan (Logika dari JS)
            foreach ($cleanedRows as $row) {


                if (!isset($row[$columnIndexForToday])) {
                    continue;
                }

                $nama = $row[1] ?? ''; // Menggunakan 'nama' sesuai perbaikan sebelumnya
                $jabatan = strtoupper(trim($row[3] ?? ''));
                $shiftCode = strtoupper(trim($row[$columnIndexForToday])); // Sekarang ini aman

                $keterangan = isset($row[$ketColumnIndex]) ? strtoupper(trim($row[$ketColumnIndex])) : '';

                if (isset($shiftDictionary[$shiftCode])) {
                    $scheduleEntry = ['name' => $nama, 'shift' => $shiftDictionary[$shiftCode]];

                    // MODIFIKASI: Tambahkan pengecekan untuk kolom Keterangan
                    // Cek #1: Apakah jabatan DIMULAI DENGAN "MT" ATAU mengandung "PT MT" ATAU Keterangan mengandung "PH MT"
                    if (str_starts_with($jabatan, 'MT') || str_contains($jabatan, 'PT MT') || str_contains($keterangan, 'PH MT')) {
                        $managerSchedule[] = $scheduleEntry;
                    }
                    // Cek #2: Jika BUKAN manager, apakah jabatannya mengandung 'TFP'?
                    else if (str_contains($jabatan, 'TFP')) {
                        $tfpSchedule[] = $scheduleEntry;
                    }
                    // Cek #3: ...
                    else {
                        $cnsSchedule[] = $scheduleEntry;
                    }
                }
            }

            // 6. Pengurutan (Logika dari JS)
            $shiftOrder = ['PAGI' => 1, 'SIANG' => 2, 'MALAM' => 3];

            $sortByShift = function ($a, $b) use ($shiftOrder) {
                $orderA = $shiftOrder[$a['shift']] ?? 99;
                $orderB = $shiftOrder[$b['shift']] ?? 99;
                if ($orderA !== $orderB) {
                    return $orderA - $orderB;
                }
                return strcmp($a['name'], $b['name']); // strcmp mirip localeCompare di JS
            };

            usort($managerSchedule, $sortByShift);
            usort($cnsSchedule, $sortByShift);
            usort($tfpSchedule, $sortByShift);

            // 7. Siapkan payload untuk dikirim sebagai JSON
            $payload = [
                'displayDate' => $displayDate,
                'manager' => $managerSchedule,
                'cns' => $cnsSchedule,
                'tfp' => $tfpSchedule,
            ];

            return response()->json($payload);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Terjadi kesalahan pada server: ' . $e->getMessage()], 500);
        }
    }
    public function getTechniciansBySchedule(Request $request)
    {
        // Mengambil tanggal dan dinas dari permintaan JavaScript
        $tanggal = $request->query('tanggal');
        $dinas = $request->query('dinas'); // Akan berisi 'PAGI', 'SIANG', atau 'MALAM'

        // TODO: Nanti, ganti logika ini untuk mengambil data dari database jadwal Anda.
        // Untuk sekarang, kita kembalikan data contoh.
        $technicians = [];

        if ($dinas === 'PAGI') {
            $technicians = ['Argo Pragolo', 'Tria Sabda Utama'];
        } elseif ($dinas === 'SIANG') {
            $technicians = ['Khoirul M.A.', 'Andi Julianto'];
        } elseif ($dinas === 'MALAM') {
            $technicians = ['Joko Febrianto', 'Nur Hukim'];
        }

        // Mengembalikan data dalam format JSON yang benar
        return response()->json([
            'success' => true,
            'data' => $technicians
        ]);
    }
}

