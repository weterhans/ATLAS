<?php

namespace App\Http\Controllers;

// 1. Pastikan Model-nya di-'use'

use App\Models\CnsdActivities; // <-- [PERBAIKAN] Pake 'CnsdActivity' (Singular)
use App\Models\CnsdSavedata;
use App\Models\SchedulesCnsd;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\CnsdEquipment;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use niklasravnsborg\LaravelPdf\Facades\Pdf;
use App\Models\DailyCnsdReports;
use Illuminate\Support\Facades\Storage;

class SaveDataCnsdController extends Controller
{
    /**
     * Tampilkan halaman save data CNSD.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $savedData = CnsdSavedata::orderBy('tanggal', 'desc')->get();
        $groupedData = $savedData->groupBy(function ($item) {
            return Carbon::parse($item->tanggal)->format('Y-m-d');
        });

        // Ambil daftar user
        $userList = User::orderBy('fullname')->pluck('fullname', 'fullname')->all();

        // Ambil daftar equipment CNSD
        $equipmentList = CnsdEquipment::orderBy('name')->pluck('name', 'name')->all();

        return view('cnsd.save_data', [
            'groupedData' => $groupedData,
            'userList' => $userList,
            'equipmentList' => $equipmentList,
        ]);
    }

    public function store(Request $request)
    {
        // 1. Validasi Awal
        $validatedData = $request->validate([
            'type' => 'required|in:Harian,Bulanan',
            'tanggal' => 'required|date',
            'print' => 'required|in:YA,TIDAK',
            'grup' => 'required|string',
        ]);

        // 2. Validasi Kondisional
        if ($request->input('type') === 'Harian') {
            $validatedData = array_merge($validatedData, $request->validate([
                'dinas' => 'required|in:PAGI,SIANG,MALAM',
                'mantek' => 'required|string',
            ]));
            $validatedData['nama_alat'] = null;
            $validatedData['sampai'] = null;
        } elseif ($request->input('type') === 'Bulanan') {
            $validatedData = array_merge($validatedData, $request->validate([
                'nama_alat' => 'required|string',
                'sampai' => 'required|date|after_or_equal:tanggal',
            ]));
            $validatedData['dinas'] = null;
            $validatedData['mantek'] = null;
        }

        $savedData = CnsdSavedata::create($validatedData); // <-- Ubah jadi variabel

        if ($savedData->print === 'YA') {
            try {
                $relativePath = null;
                if ($savedData->type === 'Harian') {

                    $relativePath = $this->generateAndSavePdfForRecord($savedData);
                    Log::info('PDF Harian berhasil di-generate saat store.', ['id' => $savedData->id, 'path' => $relativePath]);
                } elseif ($savedData->type === 'Bulanan') {

                    // [TAMBAHAN] Panggil helper PDF Bulanan
                    $relativePath = $this->generateAndSaveMonthlyPdf($savedData);
                    Log::info('PDF Bulanan berhasil di-generate saat store.', ['id' => $savedData->id, 'path' => $relativePath]);
                }

                if ($relativePath) {
                    $savedData->file_path = $relativePath;
                    $savedData->save();
                }
            } catch (\Throwable $e) {
                Log::error('Gagal generate PDF (Harian/Bulanan) saat store.', ['id' => $savedData->id, 'error' => $e->getMessage()]);
            }
        }

        return redirect()->route('cnsd.save_data')->with('success', 'Data berhasil disimpan!');
    }

    public function update(Request $request, $id)
    {
        $savedData = CnsdSavedata::find($id);
        if (!$savedData) {
            return redirect()->route('cnsd.save_data')->withErrors('Data tidak ditemukan!');
        }

        // [PERUBAHAN] Simpan path file lama
        $oldFilePath = $savedData->file_path;

        // 1. Validasi Awal
        $validatedData = $request->validate([
            'type' => 'required|in:Harian,Bulanan',
            'tanggal' => 'required|date',
            'print' => 'required|in:YA,TIDAK',
            'grup' => 'required|string',
        ]);

        // 2. Validasi Kondisional
        if ($request->input('type') === 'Harian') {
            $validatedData = array_merge($validatedData, $request->validate([
                'dinas' => 'required|in:PAGI,SIANG,MALAM',
                'mantek' => 'required|string',
            ]));
            $validatedData['nama_alat'] = null;
            $validatedData['sampai'] = null;
        } elseif ($request->input('type') === 'Bulanan') {
            $validatedData = array_merge($validatedData, $request->validate([
                'nama_alat' => 'required|string',
                'sampai' => 'required|date|after_or_equal:tanggal',
            ]));
            $validatedData['dinas'] = null;
            $validatedData['mantek'] = null;
        }

        // 3. Update
        $savedData->update($validatedData);

        // [PERUBAHAN] 4. Cek ulang PDF
        $newFilePath = null;
        try {
            if ($savedData->print === 'YA') {
                if ($savedData->type === 'Harian') {

                    $newFilePath = $this->generateAndSavePdfForRecord($savedData);
                    Log::info('PDF Harian di-generate ulang saat update.', ['id' => $savedData->id, 'path' => $newFilePath]);
                } elseif ($savedData->type === 'Bulanan') {

                    // [TAMBAHAN] Panggil helper PDF Bulanan
                    $newFilePath = $this->generateAndSaveMonthlyPdf($savedData);
                    Log::info('PDF Bulanan di-generate ulang saat update.', ['id' => $savedData->id, 'path' => $newFilePath]);
                }
            }

            // Update path di DB
            $savedData->file_path = $newFilePath;
            $savedData->save();

            // Hapus file lama jika path-nya beda DAN file lama ada
            // [PERBAIKAN] Ganti 'public' menjadi 'local'
            if ($oldFilePath && $oldFilePath !== $newFilePath && Storage::disk('local')->exists($oldFilePath)) {
                Storage::disk('local')->delete($oldFilePath);
                Log::info('File PDF lama dihapus saat update (disk local).', ['id' => $savedData->id, 'old_path' => $oldFilePath]);
            }
        } catch (\Throwable $e) {
            Log::error('Gagal generate/hapus PDF (Harian/Bulanan) saat update.', ['id' => $savedData->id, 'error' => $e->getMessage()]);
        }

        return redirect()->route('cnsd.save_data')->with('success', 'Data berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $savedData = CnsdSavedata::find($id);
        if ($savedData) {
            if ($savedData->file_path && Storage::disk('local')->exists($savedData->file_path)) {
                try {
                    Storage::disk('local')->delete($savedData->file_path);
                    Log::info('File PDF dihapus saat destroy (disk local).', ['id' => $savedData->id, 'path' => $savedData->file_path]);
                } catch (\Throwable $e) {
                    Log::error('Gagal hapus file PDF saat destroy.', ['id' => $savedData->id, 'error' => $e->getMessage()]);
                }
            }

            $savedData->delete();
            return redirect()->route('cnsd.save_data')->with('success', 'Data berhasil dihapus!');
        }
        return redirect()->route('cnsd.save_data')->withErrors('Gagal menghapus data: tidak ditemukan.');
    }

    public function getRelatedSchedule(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date_format:Y-m-d',
            'dinas' => 'required|string|in:PAGI,SIANG,MALAM',
        ]);

        // Cari jadwal berdasarkan tanggal dan dinas
        $schedule = SchedulesCnsd::where('tanggal', $request->tanggal)
            ->whereRaw('UPPER(dinas) = ?', [strtoupper($request->dinas)])
            ->first();

        if ($schedule) {
            // Format data sesuai kebutuhan
            $schedule->id_jadwal = $schedule->kode_jadwal ?? (strtoupper($schedule->dinas) . '-' . Carbon::parse($schedule->tanggal)->format('d/m/Y') . '-' . $schedule->grup);
            $schedule->teknisi1 = $schedule->teknisi_1 ?? '-';
            $schedule->teknisi2 = $schedule->teknisi_2 ?? '-';
            $schedule->teknisi3 = $schedule->teknisi_3 ?? '-';
            $schedule->kode = $schedule->kode_jadwal ?? $schedule->id_jadwal; // fallback

            return response()->json(['success' => true, 'schedule' => $schedule]);
        } else {
            return response()->json(['success' => false, 'message' => 'Jadwal dinas tidak ditemukan untuk shift ini.']);
        }
    }

    public function getRelatedActivity(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date_format:Y-m-d',
            'dinas' => 'required|string|in:PAGI,SIANG,MALAM',
        ]);

        // [PERBAIKAN] Ganti CnsdActivities jadi CnsdActivity
        $activity = CnsdActivities::where('tanggal', $request->tanggal)
            ->whereRaw('UPPER(dinas) = ?', [strtoupper($request->dinas)])
            ->orderBy('waktu_mulai', 'asc')
            ->first();

        if ($activity) {
            // Format data
            $activity->kode = $activity->kode_kegiatan ?? ('KG-CNSD-' . rand(100000, 999999)); // Fallback jika kode null
            $activity->tanggal_formatted = Carbon::parse($activity->tanggal)->format('d/m/Y');
            $activity->waktu_mulai = Carbon::parse($activity->waktu_mulai)->format('H:i:s'); // Format ke H:i:s
            $activity->waktu_selesai = Carbon::parse($activity->waktu_selesai)->format('H:i:s'); // Format ke H:i:s
            $activity->teknisi_formatted = is_array($activity->teknisi) ? implode(', ', $activity->teknisi) : (is_string($activity->teknisi) ? $activity->teknisi : '-');
            $activity->lampiran_count = is_array($activity->lampiran) ? count(array_filter($activity->lampiran)) : 0;
            $activity->waktu_putus = $activity->waktu_terputus ?? '-'; // Sesuaikan nama field

            return response()->json(['success' => true, 'activity' => $activity]);
        } else {
            return response()->json(['success' => false, 'message' => 'Detail kegiatan tidak ditemukan untuk shift ini.']);
        }
    }

    public function getActivitiesForDateRange(Request $request)
    {
        $validated = $request->validate([
            'start_date' => 'required|date_format:Y-m-d',
            'end_date' => 'required|date_format:Y-m-d|after_or_equal:start_date',
        ]);

        // [PERBAIKAN] Ganti CnsdActivities jadi CnsdActivity
        $activities = CnsdActivities::whereBetween('tanggal', [$validated['start_date'], $validated['end_date']])
            ->orderBy('tanggal', 'asc')
            ->orderBy('waktu_mulai', 'asc')
            ->get();

        if ($activities->isEmpty()) {
            return response()->json(['success' => false, 'message' => 'Tidak ada kegiatan yang ditemukan dalam rentang tanggal ini.']);
        }

        // Format setiap data
        $formattedActivities = $activities->map(function ($activity) {
            $activity->kode = $activity->kode_kegiatan ?? ('KG-CNSD-' . rand(100000, 999999));
            $activity->waktu_mulai = Carbon::parse($activity->waktu_mulai)->format('H:i:s');
            $activity->waktu_selesai = Carbon::parse($activity->waktu_selesai)->format('H:i:s');
            $activity->teknisi_formatted = is_array($activity->teknisi) ? implode(', ', $activity->teknisi) : (is_string($activity->teknisi) ? $activity->teknisi : '-');
            $activity->lampiran_count = is_array($activity->lampiran) ? count(array_filter($activity->lampiran)) : 0;
            $activity->waktu_putus = $activity->waktu_terputus ?? '-';

            // Buat field untuk grouping dan display
            $activity->tanggal_group = Carbon::parse($activity->tanggal)->format('Y-m-d');
            $activity->tanggal_display = Carbon::parse($activity->tanggal)->isoFormat('dddd, D MMMM YYYY');
            return $activity;
        });

        // Grouping berdasarkan tanggal
        $groupedActivities = $formattedActivities->groupBy('tanggal_group');

        return response()->json(['success' => true, 'groupedActivities' => $groupedActivities]);
    }

    public function getSchedulesForDateRange(Request $request)
    {
        $validated = $request->validate([
            'start_date' => 'required|date_format:Y-m-d',
            'end_date' => 'required|date_format:Y-m-d|after_or_equal:start_date',
        ]);

        $schedules = SchedulesCnsd::whereBetween('tanggal', [$validated['start_date'], $validated['end_date']])
            ->orderBy('tanggal', 'asc')
            // ->orderBy('dinas', 'asc') // Opsional, urutkan berdasarkan dinas jika perlu
            ->get();

        if ($schedules->isEmpty()) {
            return response()->json(['success' => false, 'message' => 'Tidak ada jadwal yang ditemukan dalam rentang tanggal ini.']);
        }

        // Format setiap data
        $formattedSchedules = $schedules->map(function ($schedule) {
            $schedule->id_jadwal = $schedule->kode_jadwal ?? (strtoupper($schedule->dinas) . '-' . Carbon::parse($schedule->tanggal)->format('d/m/Y') . '-' . $schedule->grup);
            $schedule->teknisi1 = $schedule->teknisi_1 ?? '-';
            $schedule->teknisi2 = $schedule->teknisi_2 ?? '-';
            $schedule->teknisi3 = $schedule->teknisi_3 ?? '-';
            $schedule->kode = $schedule->kode_jadwal ?? $schedule->id_jadwal; // fallback

            // Buat field untuk grouping dan display
            $schedule->tanggal_group = Carbon::parse($schedule->tanggal)->format('Y-m-d');
            $schedule->tanggal_display = Carbon::parse($schedule->tanggal)->isoFormat('dddd, D MMMM YYYY');
            return $schedule;
        });

        // Grouping berdasarkan tanggal
        $groupedSchedules = $formattedSchedules->groupBy('tanggal_group');

        return response()->json(['success' => true, 'groupedSchedules' => $groupedSchedules]);
    }


    protected function generateAndSavePdfForRecord(CnsdSavedata $savedData)
    {
        Log::info('Helper generateAndSavePdfForRecord dipanggil.', ['id' => $savedData->id]);
        if ($savedData->type !== 'Harian') {
            Log::warning('generateAndSavePdfForRecord dipanggil untuk tipe non-Harian.', ['id' => $savedData->id]);
            return null;
        }

        try {
            // 1. Ambil data equipment
            $equipmentList = CnsdEquipment::orderBy('id', 'asc')->get();

            // 2. Ambil data jadwal/personel
            $schedule = SchedulesCnsd::where('tanggal', $savedData->tanggal->format('Y-m-d'))
                ->whereRaw('UPPER(dinas) = ?', [strtoupper($savedData->dinas)])
                ->first();

            $personnel = [];
            if ($schedule) {
                $teknisiNames = array_filter([$schedule->teknisi_1, $schedule->teknisi_2, $schedule->teknisi_3]);
                if (!empty($teknisiNames)) {
                    $usersData = User::whereIn('fullname', $teknisiNames)->pluck('signature_url', 'fullname')->all();
                    foreach ($teknisiNames as $name) {
                        $personnel[] = (object) ['name' => $name, 'signature_url' => $usersData[$name] ?? null];
                    }
                }
            }

            // 3. Ambil status equipment & TTD Mantek
            $dailyReportRecord = DailyCnsdReports::where('tanggal', $savedData->tanggal->format('Y-m-d'))
                ->whereRaw('UPPER(dinas) = ?', [strtoupper($savedData->dinas)])
                ->first();

            $equipmentStatusData = null;
            $jsonColumnName = 'equipment_status';
            if ($dailyReportRecord && !empty($dailyReportRecord->$jsonColumnName) && is_array($dailyReportRecord->$jsonColumnName)) {
                $equipmentStatusData = $dailyReportRecord->$jsonColumnName;
            }

            $mantekName = $savedData->mantek;
            $mantekSignatureUrl = null;
            if (!empty($mantekName)) {
                $mantekUser = User::where('fullname', $mantekName)->first();
                if ($mantekUser) {
                    $mantekSignatureUrl = $mantekUser->signature_url;
                }
            }

            // 4. Siapkan data untuk view PDF
            $data = [
                'tanggal' => $savedData->tanggal->format('d/m/Y'),
                'dinas' => $savedData->dinas,
                'equipmentList' => $equipmentList,
                'personnel' => $personnel,
                'mantekName' => $savedData->mantek,
                'mantekSignatureUrl' => $mantekSignatureUrl,
                'equipmentStatus' => $equipmentStatusData,
            ];

            // 5. Load view PDF
            $pdf = Pdf::loadView('cnsd.report_pdf', $data);

            // 6. Tentukan nama file dan path RELATIF ke disk 'public'
            $fileName = 'Laporan_Harian_CNSD_' . $savedData->tanggal->format('Ymd') . '_' . $savedData->dinas . '_' . $savedData->id . '_' . time() . '.pdf';

            // [PERUBAHAN DI SINI] Ubah 'temp_pdfs' menjadi 'pdf'
            $directory = 'pdf_reports_secure'; // Folder aman
            $relativePath = $directory . '/' . $fileName;

            /** @var \niklasravnsborg\LaravelPdf\Pdf $pdf */
            // 7. Simpan file menggunakan disk 'local' (AMAN DARI ANTIVIRUS)
            $pdfOutput = $pdf->output();
            Storage::disk('local')->put($relativePath, $pdfOutput);

            Log::info('PDF helper sukses generate & save.', ['id' => $savedData->id, 'path' => $relativePath]);

            // 8. Kembalikan relative path
            return $relativePath;
        } catch (\Throwable $e) {
            Log::error('--- PDF Generation FAILED (helper function) --- Exception caught:', [
                'id' => $savedData->id,
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);
            return null; // Kembalikan null jika gagal
        }
    }

    protected function generateAndSaveMonthlyPdf(CnsdSavedata $savedData)
    {
        Log::info('Helper generateAndSaveMonthlyPdf dipanggil.', ['id' => $savedData->id]);
        if ($savedData->type !== 'Bulanan') {
            Log::warning('generateAndSaveMonthlyPdf dipanggil untuk tipe non-Bulanan.', ['id' => $savedData->id]);
            return null;
        }

        try {
            // 1. Ambil data dasar
            $startDate = $savedData->tanggal;
            $endDate = $savedData->sampai;
            $alatFilter = $savedData->nama_alat;

            // 2. Ambil data kegiatan
            // [PERBAIKAN] Ganti CnsdActivities jadi CnsdActivity
            $query = CnsdActivities::whereBetween('tanggal', [$startDate, $endDate]);

            // Tambahkan filter NAMA ALAT jika BUKAN "ALL Equipment"
            if ($alatFilter && $alatFilter !== 'ALL Equipment') {
                $query->where('alat', $alatFilter);
            }

            $activities = $query->orderBy('tanggal', 'asc')
                ->orderBy('waktu_mulai', 'asc')
                ->get();

            // 3. Format data untuk view
            $formattedActivities = $activities->map(function ($item) use ($alatFilter) { // <-- 1. TAMBAH 'use ($alatFilter)'
                return (object) [
                    'tanggal_formatted' => Carbon::parse($item->tanggal)->format('d/m/Y'),
                    'jam_mulai' => Carbon::parse($item->waktu_mulai)->format('H:i:s'),
                    'jam_selesai' => Carbon::parse($item->waktu_selesai)->format('H:i:s'),
                    'nama_alat' => $alatFilter, // <-- 2. GANTI JADI '$alatFilter' (data dari cnsd_savedata)
                    'kegiatan' => $item->tindakan ?? '-', // Sesuai permintaan
                    'terputus' => $item->waktu_terputus ?? '-', // Sesuai gambar
                ];
            });

            // 4. Siapkan data untuk view PDF
            $data = [
                'reportTitle' => 'Daftar Kegiatan ' . ($alatFilter ?? 'Semua Alat'),
                'dateRange' => $startDate->isoFormat('D MMMM YYYY') . ' - ' . $endDate->isoFormat('D MMMM YYYY'),
                'activities' => $formattedActivities,
            ];

            // 5. Load view PDF
            $pdf = Pdf::loadView('cnsd.report_monthly_pdf', $data);

            // 6. Tentukan nama file dan path (pake disk 'local' yang aman)
            $safeAlatName = str_replace(['/', '\\', ' '], '_', $alatFilter);
            $fileName = 'Laporan_Bulanan_CNSD_' . $safeAlatName . '_' . $savedData->id . '_' . time() . '.pdf';
            $directory = 'pdf_reports_secure'; // Folder aman yang sama
            $relativePath = $directory . '/' . $fileName;

            /** @var \niklasravnsborg\LaravelPdf\Pdf $pdf */
            $pdfOutput = $pdf->output();
            Storage::disk('local')->put($relativePath, $pdfOutput);

            Log::info('PDF Bulanan helper sukses generate & save.', ['id' => $savedData->id, 'path' => $relativePath]);

            // 7. Kembalikan relative path
            return $relativePath;
        } catch (\Throwable $e) {
            Log::error('--- PDF Generation FAILED (helper function BULANAN) --- Exception caught:', [
                'id' => $savedData->id,
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);
            return null; // Kembalikan null jika gagal
        }
    }

    public function downloadReport($id)
    {
        Log::info('Mencoba download untuk ID: ' . $id);
        try {
            $savedData = CnsdSavedata::find($id);

            if (!$savedData) {
                Log::error('Data tidak ditemukan untuk download.', ['id' => $id]);
                return redirect()->back()->withErrors('Data laporan tidak ditemukan.');
            }

            $filePath = $savedData->file_path;

            if (!$filePath) {
                Log::error('File path kosong di database.', ['id' => $id]);
                return redirect()->back()->withErrors('File path tidak terdaftar di database.');
            }

            // Cek apakah file-nya beneran ada di "gudang" (storage/app/pdf_reports_secure)
            if (!Storage::disk('local')->exists($filePath)) {
                Log::error('File fisik tidak ada di storage.', ['id' => $id, 'path' => $filePath]);
                return redirect()->back()->withErrors('File fisik tidak ditemukan di server.');
            }

            // Ambil path lengkap (absolut) ke file-nya
            $absolutePath = Storage::disk('local')->path($filePath);

            // Tentukan nama file yang akan di-download oleh user
            $fileName = basename($filePath);

            Log::info('File ditemukan, memulai download.', ['id' => $id, 'path' => $absolutePath]);

            // Ini adalah "sihir"-nya. PHP yang baca file, bukan Apache.
            return response()->download($absolutePath, $fileName);
        } catch (\Throwable $e) {
            Log::critical('Error saat download file.', [
                'id' => $id,
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            return redirect()->back()->withErrors('Terjadi error internal saat mencoba download file.');
        }
    }
} // <-- [PERBAIKAN] KURUNG KURAWAL EKSTRA SUDAH DIHAPUS. INI ADALAH AKHIR FILE.
