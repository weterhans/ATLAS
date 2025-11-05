<?php

namespace App\Http\Controllers;


use App\Models\TfpActivities;
use App\Models\SaveDataTfp;
use App\Models\SchedulesTfp;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\TfpEquipment;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use niklasravnsborg\LaravelPdf\Facades\Pdf;
use App\Models\DailyTfpReports;
use Illuminate\Support\Facades\Storage;

class SaveDataTfpController extends Controller
{
    /**
     * Tampilkan halaman save data TFP.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $savedData = SaveDataTfp::orderBy('tanggal', 'desc')->get(); // Model TFP
        $groupedData = $savedData->groupBy(function ($item) {
            return Carbon::parse($item->tanggal)->format('Y-m-d');
        });

        // Ambil daftar user
        $userList = User::orderBy('fullname')->pluck('fullname', 'fullname')->all();

        // Ambil daftar equipment TFP
        $equipmentList = TfpEquipment::orderBy('name')->pluck('name', 'name')->all(); // Model TFP

        return view('tfp.save_data', [ // <-- View TFP
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

        // 2. Validasi Kondisional (Sama)
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

        $savedData = SaveDataTfp::create($validatedData); // <-- Model TFP

        if ($savedData->print === 'YA') {
            try {
                $relativePath = null;
                if ($savedData->type === 'Harian') {
                    $relativePath = $this->generateAndSavePdfForRecord($savedData);
                    Log::info('PDF Harian TFP berhasil di-generate saat store.', ['id' => $savedData->id, 'path' => $relativePath]);
                } elseif ($savedData->type === 'Bulanan') {
                    $relativePath = $this->generateAndSaveMonthlyPdf($savedData);
                    Log::info('PDF Bulanan TFP berhasil di-generate saat store.', ['id' => $savedData->id, 'path' => $relativePath]);
                }

                if ($relativePath) {
                    $savedData->file_path = $relativePath;
                    $savedData->save();
                }
            } catch (\Throwable $e) {
                Log::error('Gagal generate PDF TFP (Harian/Bulanan) saat store.', ['id' => $savedData->id, 'error' => $e->getMessage()]);
            }
        }

        return redirect()->route('tfp.save_data')->with('success', 'Data berhasil disimpan!'); // <-- Route TFP
    }

    public function update(Request $request, $id)
    {
        $savedData = SaveDataTfp::find($id); // <-- Model TFP
        if (!$savedData) {
            return redirect()->route('tfp.save_data')->withErrors('Data tidak ditemukan!'); // <-- Route TFP
        }

        $oldFilePath = $savedData->file_path;

        // 1. Validasi Awal
        $validatedData = $request->validate([
            'type' => 'required|in:Harian,Bulanan',
            'tanggal' => 'required|date',
            'print' => 'required|in:YA,TIDAK',
            'grup' => 'required|string',
        ]);

        // 2. Validasi Kondisional (Sama)
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

        // 4. Cek ulang PDF
        $newFilePath = null;
        try {
            if ($savedData->print === 'YA') {
                if ($savedData->type === 'Harian') {
                    $newFilePath = $this->generateAndSavePdfForRecord($savedData);
                    Log::info('PDF Harian TFP di-generate ulang saat update.', ['id' => $savedData->id, 'path' => $newFilePath]);
                } elseif ($savedData->type === 'Bulanan') {
                    $newFilePath = $this->generateAndSaveMonthlyPdf($savedData);
                    Log::info('PDF Bulanan TFP di-generate ulang saat update.', ['id' => $savedData->id, 'path' => $newFilePath]);
                }
            }

            $savedData->file_path = $newFilePath;
            $savedData->save();

            if ($oldFilePath && $oldFilePath !== $newFilePath && Storage::disk('local')->exists($oldFilePath)) {
                Storage::disk('local')->delete($oldFilePath);
                Log::info('File PDF TFP lama dihapus saat update (disk local).', ['id' => $savedData->id, 'old_path' => $oldFilePath]);
            }
        } catch (\Throwable $e) {
            Log::error('Gagal generate/hapus PDF TFP (Harian/Bulanan) saat update.', ['id' => $savedData->id, 'error' => $e->getMessage()]);
        }

        return redirect()->route('tfp.save_data')->with('success', 'Data berhasil diperbarui!'); // <-- Route TFP
    }

    public function destroy($id)
    {
        $savedData = SaveDataTfp::find($id); // <-- Model TFP
        if ($savedData) {
            if ($savedData->file_path && Storage::disk('local')->exists($savedData->file_path)) {
                try {
                    Storage::disk('local')->delete($savedData->file_path);
                    Log::info('File PDF TFP dihapus saat destroy (disk local).', ['id' => $savedData->id, 'path' => $savedData->file_path]);
                } catch (\Throwable $e) {
                    Log::error('Gagal hapus file PDF TFP saat destroy.', ['id' => $savedData->id, 'error' => $e->getMessage()]);
                }
            }

            $savedData->delete();
            return redirect()->route('tfp.save_data')->with('success', 'Data berhasil dihapus!'); // <-- Route TFP
        }
        return redirect()->route('tfp.save_data')->withErrors('Gagal menghapus data: tidak ditemukan.'); // <-- Route TFP
    }

    public function getRelatedSchedule(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date_format:Y-m-d',
            'dinas' => 'required|string|in:PAGI,SIANG,MALAM',
        ]);

        // Cari jadwal TFP
        $schedule = SchedulesTfp::where('tanggal', $request->tanggal) // <-- Model TFP
            ->whereRaw('UPPER(dinas) = ?', [strtoupper($request->dinas)])
            ->first();

        if ($schedule) {
            $schedule->id_jadwal = $schedule->kode_jadwal ?? (strtoupper($schedule->dinas) . '-' . Carbon::parse($schedule->tanggal)->format('d/m/Y') . '-' . $schedule->grup);
            $schedule->teknisi1 = $schedule->teknisi_1 ?? '-';
            $schedule->teknisi2 = $schedule->teknisi_2 ?? '-';
            $schedule->teknisi3 = $schedule->teknisi_3 ?? '-';
            $schedule->kode = $schedule->kode_jadwal ?? $schedule->id_jadwal;
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

        // Cari kegiatan TFP
        $activity = TfpActivities::where('tanggal', $request->tanggal) // <-- Model TFP
            ->whereRaw('UPPER(dinas) = ?', [strtoupper($request->dinas)])
            ->orderBy('waktu_mulai', 'asc')
            ->first();

        if ($activity) {
            $activity->kode = $activity->kode_kegiatan ?? ('KG-TFP-' . rand(100000, 999999)); // <-- Label TFP
            $activity->tanggal_formatted = Carbon::parse($activity->tanggal)->format('d/m/Y');
            $activity->waktu_mulai = Carbon::parse($activity->waktu_mulai)->format('H:i:s');
            $activity->waktu_selesai = Carbon::parse($activity->waktu_selesai)->format('H:i:s');
            $activity->teknisi_formatted = is_array($activity->teknisi) ? implode(', ', $activity->teknisi) : (is_string($activity->teknisi) ? $activity->teknisi : '-');
            $activity->lampiran_count = is_array($activity->lampiran) ? count(array_filter($activity->lampiran)) : 0;
            $activity->waktu_putus = $activity->waktu_terputus ?? '-';
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

        // Cari kegiatan TFP
        $activities = TfpActivities::whereBetween('tanggal', [$validated['start_date'], $validated['end_date']]) // <-- Model TFP
            ->orderBy('tanggal', 'asc')
            ->orderBy('waktu_mulai', 'asc')
            ->get();

        if ($activities->isEmpty()) {
            return response()->json(['success' => false, 'message' => 'Tidak ada kegiatan yang ditemukan dalam rentang tanggal ini.']);
        }

        $formattedActivities = $activities->map(function ($activity) {
            $activity->kode = $activity->kode_kegiatan ?? ('KG-TFP-' . rand(100000, 999999)); // <-- Label TFP
            $activity->waktu_mulai = Carbon::parse($activity->waktu_mulai)->format('H:i:s');
            $activity->waktu_selesai = Carbon::parse($activity->waktu_selesai)->format('H:i:s');
            $activity->teknisi_formatted = is_array($activity->teknisi) ? implode(', ', $activity->teknisi) : (is_string($activity->teknisi) ? $activity->teknisi : '-');
            $activity->lampiran_count = is_array($activity->lampiran) ? count(array_filter($activity->lampiran)) : 0;
            $activity->waktu_putus = $activity->waktu_terputus ?? '-';
            $activity->tanggal_group = Carbon::parse($activity->tanggal)->format('Y-m-d');
            $activity->tanggal_display = Carbon::parse($activity->tanggal)->isoFormat('dddd, D MMMM YYYY');
            return $activity;
        });

        $groupedActivities = $formattedActivities->groupBy('tanggal_group');
        return response()->json(['success' => true, 'groupedActivities' => $groupedActivities]);
    }

    public function getSchedulesForDateRange(Request $request)
    {
        $validated = $request->validate([
            'start_date' => 'required|date_format:Y-m-d',
            'end_date' => 'required|date_format:Y-m-d|after_or_equal:start_date',
        ]);

        // Cari jadwal TFP
        $schedules = SchedulesTfp::whereBetween('tanggal', [$validated['start_date'], $validated['end_date']]) // <-- Model TFP
            ->orderBy('tanggal', 'asc')
            ->get();

        if ($schedules->isEmpty()) {
            return response()->json(['success' => false, 'message' => 'Tidak ada jadwal yang ditemukan dalam rentang tanggal ini.']);
        }

        $formattedSchedules = $schedules->map(function ($schedule) {
            $schedule->id_jadwal = $schedule->kode_jadwal ?? (strtoupper($schedule->dinas) . '-' . Carbon::parse($schedule->tanggal)->format('d/m/Y') . '-' . $schedule->grup);
            $schedule->teknisi1 = $schedule->teknisi_1 ?? '-';
            $schedule->teknisi2 = $schedule->teknisi_2 ?? '-';
            $schedule->teknisi3 = $schedule->teknisi_3 ?? '-';
            $schedule->kode = $schedule->kode_jadwal ?? $schedule->id_jadwal;
            $schedule->tanggal_group = Carbon::parse($schedule->tanggal)->format('Y-m-d');
            $schedule->tanggal_display = Carbon::parse($schedule->tanggal)->isoFormat('dddd, D MMMM YYYY');
            return $schedule;
        });

        $groupedSchedules = $formattedSchedules->groupBy('tanggal_group');
        return response()->json(['success' => true, 'groupedSchedules' => $groupedSchedules]);
    }

    protected function generateAndSavePdfForRecord(SaveDataTfp $savedData) // <-- Model TFP
    {
        Log::info('Helper TFP generateAndSavePdfForRecord dipanggil.', ['id' => $savedData->id]);
        if ($savedData->type !== 'Harian') {
            Log::warning('generateAndSavePdfForRecord TFP dipanggil untuk tipe non-Harian.', ['id' => $savedData->id]);
            return null;
        }

        try {
            // 1. Ambil data equipment TFP
            $equipmentList = TfpEquipment::orderBy('id', 'asc')->get(); // <-- Model TFP

            // 2. Ambil data jadwal/personel TFP
            $schedule = SchedulesTfp::where('tanggal', $savedData->tanggal->format('Y-m-d')) // <-- Model TFP
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

            // 3. Ambil status equipment & TTD Mantek TFP
            $dailyReportRecord = DailyTfpReports::where('tanggal', $savedData->tanggal->format('Y-m-d')) // <-- Model TFP
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

            // 5. Load view PDF TFP (HARUS DIBUAT)
            $pdf = Pdf::loadView('tfp.report_pdf', $data); // <-- View TFP

            // 6. Tentukan nama file
            $fileName = 'Laporan_Harian_TFP_' . $savedData->tanggal->format('Ymd') . '_' . $savedData->dinas . '_' . $savedData->id . '_' . time() . '.pdf'; // <-- Nama TFP
            $directory = 'pdf_reports_secure';
            $relativePath = $directory . '/' . $fileName;

            /** @var \niklasravnsborg\LaravelPdf\Pdf $pdf */
            $pdfOutput = $pdf->output();
            Storage::disk('local')->put($relativePath, $pdfOutput);
            Log::info('PDF TFP helper sukses generate & save.', ['id' => $savedData->id, 'path' => $relativePath]);
            return $relativePath;
        } catch (\Throwable $e) {
            Log::error('--- PDF Generation FAILED (helper function TFP) --- Exception caught:', [
                'id' => $savedData->id,
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);
            return null;
        }
    }

    protected function generateAndSaveMonthlyPdf(SaveDataTfp $savedData) // <-- Model TFP
    {
        Log::info('Helper TFP generateAndSaveMonthlyPdf dipanggil.', ['id' => $savedData->id]);
        if ($savedData->type !== 'Bulanan') {
            Log::warning('generateAndSaveMonthlyPdf TFP dipanggil untuk tipe non-Bulanan.', ['id' => $savedData->id]);
            return null;
        }

        try {
            // 1. Ambil data dasar
            $startDate = $savedData->tanggal;
            $endDate = $savedData->sampai;
            $alatFilter = $savedData->nama_alat;

            // 2. Ambil data kegiatan TFP
            $query = TfpActivities::whereBetween('tanggal', [$startDate, $endDate]); // <-- Model TFP
            if ($alatFilter && $alatFilter !== 'ALL Equipment') {
                $query->where('alat', $alatFilter);
            }
            $activities = $query->orderBy('tanggal', 'asc')
                ->orderBy('waktu_mulai', 'asc')
                ->get();

            // 3. Format data untuk view
            $formattedActivities = $activities->map(function ($item) use ($alatFilter) {
                return (object) [
                    'tanggal_formatted' => Carbon::parse($item->tanggal)->format('d/m/Y'),
                    'jam_mulai' => Carbon::parse($item->waktu_mulai)->format('H:i:s'),
                    'jam_selesai' => Carbon::parse($item->waktu_selesai)->format('H:i:s'),
                    'nama_alat' => $alatFilter,
                    'kegiatan' => $item->tindakan ?? '-',
                    'terputus' => $item->waktu_terputus ?? '-',
                ];
            });

            // 4. Siapkan data untuk view PDF
            $data = [
                'reportTitle' => 'Daftar Kegiatan ' . ($alatFilter ?? 'Semua Alat'),
                'dateRange' => $startDate->isoFormat('D MMMM YYYY') . ' - ' . $endDate->isoFormat('D MMMM YYYY'),
                'activities' => $formattedActivities,
            ];

            // 5. Load view PDF TFP (HARUS DIBUAT)
            $pdf = Pdf::loadView('tfp.report_monthly_pdf', $data); // <-- View TFP

            // 6. Tentukan nama file
            $safeAlatName = str_replace(['/', '\\', ' '], '_', $alatFilter);
            $fileName = 'Laporan_Bulanan_TFP_' . $safeAlatName . '_' . $savedData->id . '_' . time() . '.pdf'; // <-- Nama TFP
            $directory = 'pdf_reports_secure';
            $relativePath = $directory . '/' . $fileName;

            /** @var \niklasravnsborg\LaravelPdf\Pdf $pdf */
            $pdfOutput = $pdf->output();
            Storage::disk('local')->put($relativePath, $pdfOutput);
            Log::info('PDF Bulanan TFP helper sukses generate & save.', ['id' => $savedData->id, 'path' => $relativePath]);
            return $relativePath;
        } catch (\Throwable $e) {
            Log::error('--- PDF Generation FAILED (helper function BULANAN TFP) --- Exception caught:', [
                'id' => $savedData->id,
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);
            return null;
        }
    }

    public function downloadReport($id)
    {
        Log::info('Mencoba download TFP untuk ID: ' . $id);
        try {
            $savedData = SaveDataTfp::find($id); // <-- Model TFP

            if (!$savedData) {
                Log::error('Data TFP tidak ditemukan untuk download.', ['id' => $id]);
                return redirect()->back()->withErrors('Data laporan tidak ditemukan.');
            }

            $filePath = $savedData->file_path;
            if (!$filePath) {
                Log::error('File path TFP kosong di database.', ['id' => $id]);
                return redirect()->back()->withErrors('File path tidak terdaftar di database.');
            }

            if (!Storage::disk('local')->exists($filePath)) {
                Log::error('File fisik TFP tidak ada di storage.', ['id' => $id, 'path' => $filePath]);
                return redirect()->back()->withErrors('File fisik tidak ditemukan di server.');
            }

            $absolutePath = Storage::disk('local')->path($filePath);
            $fileName = basename($filePath);
            Log::info('File TFP ditemukan, memulai download.', ['id' => $id, 'path' => $absolutePath]);
            return response()->download($absolutePath, $fileName);

        } catch (\Throwable $e) {
            Log::critical('Error saat download file TFP.', [
                'id' => $id,
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            return redirect()->back()->withErrors('Terjadi error internal saat mencoba download file.');
        }
    }
}
