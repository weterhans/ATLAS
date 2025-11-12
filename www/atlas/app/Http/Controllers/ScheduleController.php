<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

class ScheduleController extends Controller
{
    public function getScheduleData()
    {
        // PASTIKAN LINK INI ADALAH LINK DARI TAB (SHEET) YANG BENAR (MISAL: NOVEMBER)
        $googleSheetUrl = 'https://docs.google.com/spreadsheets/d/e/2PACX-1vTTgyK8hLDZajIXckdGcBuV9W4zVgT_QGqVK7irDc0fqPUNHgpxai2X9Pk6vj5qz22xBozTruWkWx8z/pub?gid=1358398093&single=true&output=csv';

        try {
            $response = Http::get($googleSheetUrl);

            if ($response->failed()) {
                return response()->json(['error' => 'Gagal mengambil data dari Google Sheet.'], 500);
            }

            $csvData = $response->body();
            $allRows = str_getcsv($csvData, "\n"); // Pisahkan per baris
            array_shift($allRows); // Hapus baris header

            // 1. Pembersihan Data
            $cleanedRows = [];
            foreach ($allRows as $rowStr) {
                $row = str_getcsv($rowStr, ",");
                if (is_array($row) && count($row) > 3 && !empty(trim($row[1] ?? '')) && !empty(trim($row[3] ?? ''))) {
                    $cleanedRows[] = $row;
                }
            }

            // 2. Setup tanggal & kolom
            $today = Carbon::now('Asia/Jakarta');
            $displayDate = $today->translatedFormat('l, d F Y');
            $todayDate = $today->day;
            $offsetColumns = 4; // NO, NAMA, KELAS JABATAN, JABATAN
            $columnIndexForToday = $offsetColumns + $todayDate - 1;
            $ketColumnIndex = 34; // Kolom Keterangan (AI)

            // 3. Kamus shift
            $shiftDictionary = ['P' => 'PAGI', 'S' => 'SIANG', 'M' => 'MALAM'];

            // 4. Wadah Kategori
            $managerSchedule = [];
            $cnsSchedule = [];
            $tfpSchedule = [];
            $phTechnicians = []; // Simpan PH MT sementara
            $realManagerShifts = []; // Catat shift yang sudah diisi MT asli
            $processedNames = []; // --- PERBAIKAN: Untuk mencegah duplikat

            // --- LOGIKA BARU: Langkah 1 (First Pass) ---
            // Buat daftar nama semua orang yang berstatus "PT MT" untuk bulan ini
            $ptManagerNames = [];
            foreach ($cleanedRows as $row) {
                $nama = $row[1] ?? '';
                $keterangan = isset($row[$ketColumnIndex]) ? strtoupper(trim($row[$ketColumnIndex])) : '';

                if (str_contains($keterangan, 'PT MT') && !in_array($nama, $ptManagerNames)) {
                    $ptManagerNames[] = $nama;
                }
            }

            // --- LOGIKA BARU: Langkah 2 (Second Pass) ---
            // 5. Proses dan kategorikan jadwal HARI INI
            foreach ($cleanedRows as $row) {
                $nama = $row[1] ?? '';

                // --- PERBAIKAN: Cek apakah nama ini sudah diproses dari baris duplikat
                if (in_array($nama, $processedNames)) {
                    continue; // Lewati, nama ini sudah diproses
                }

                if (!isset($row[$columnIndexForToday])) {
                    continue;
                }

                $jabatan = strtoupper(trim($row[3] ?? ''));
                $shiftCode = strtoupper(trim($row[$columnIndexForToday]));
                $keterangan = isset($row[$ketColumnIndex]) ? strtoupper(trim($row[$ketColumnIndex])) : '';

                if (isset($shiftDictionary[$shiftCode])) {
                    $shiftName = $shiftDictionary[$shiftCode];
                    $scheduleEntry = ['name' => $nama, 'shift' => $shiftName, 'jabatan' => $jabatan];

                    // Cek #1: Apakah nama ini ada di daftar "PT MT" bulanan?
                    if (in_array($nama, $ptManagerNames)) {
                        $managerSchedule[] = $scheduleEntry;
                        $processedNames[] = $nama; // Catat nama
                        if (!in_array($shiftName, $realManagerShifts)) {
                            $realManagerShifts[] = $shiftName;
                        }
                        continue;
                    }

                    // Cek #2: Apakah ini Manajer Asli (Jabatan MT)?
                    else if (str_starts_with($jabatan, 'MT') || str_contains($jabatan, 'PT MT')) {
                        $managerSchedule[] = $scheduleEntry;
                        $processedNames[] = $nama; // Catat nama
                        if (!in_array($shiftName, $realManagerShifts)) {
                            $realManagerShifts[] = $shiftName;
                        }
                        continue;
                    }

                    // Cek #3: Apakah ini Pelaksana Harian (PH MT di Keterangan)
                    else if (str_contains($keterangan, 'PH MT')) {
                        $phTechnicians[] = $scheduleEntry;
                        $processedNames[] = $nama; // Catat nama
                        continue;
                    }

                    // Cek #4: Jika BUKAN manager, apakah TFP?
                    else if (str_contains($jabatan, 'TFP')) {
                        $tfpSchedule[] = $scheduleEntry;
                        $processedNames[] = $nama; // Catat nama
                    }

                    // Cek #5: Jika bukan semua di atas, berarti CNS
                    else {
                        $cnsSchedule[] = $scheduleEntry;
                        $processedNames[] = $nama; // Catat nama
                    }
                }
            }

            // 5b. Proses PH Teknik (Pelaksana Harian)
            foreach ($phTechnicians as $phTech) {
                // Cek: Apakah shift PH ini SUDAH diisi oleh MT Asli?
                if (in_array($phTech['shift'], $realManagerShifts)) {
                    // YA: Shift sudah terisi. Kembalikan dia ke grup aslinya (CNS/TFP).
                    if (str_contains($phTech['jabatan'], 'TFP')) {
                        $tfpSchedule[] = $phTech;
                    } else {
                        $cnsSchedule[] = $phTech;
                    }
                } else {
                    // TIDAK: Shift kosong. Promosikan dia menjadi Manajer.
                    $managerSchedule[] = $phTech;
                }
            }


            // 6. Pengurutan
            $shiftOrder = ['PAGI' => 1, 'SIANG' => 2, 'MALAM' => 3];
            $sortByShift = function ($a, $b) use ($shiftOrder) {
                $orderA = $shiftOrder[$a['shift']] ?? 99;
                $orderB = $shiftOrder[$b['shift']] ?? 99;
                if ($orderA !== $orderB) {
                    return $orderA - $orderB;
                }
                return strcmp($a['name'], $b['name']);
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
