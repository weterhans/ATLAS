<?php

namespace App\Http\Controllers;

// 1. Pastikan Model-nya di-'use'

use App\Models\CnsdActivities;
use App\Models\CnsdSavedata;
use App\Models\SchedulesCnsd;
use App\Models\CnsdActivity; // <-- Pake Model yang ini
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\CnsdEquipment; // <-- Tambah ini
use Carbon\Carbon; // Opsional untuk tanggal
use Illuminate\Support\Facades\Log;
use niklasravnsborg\LaravelPdf\Facades\Pdf;

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

        // 3. Simpan
        CnsdSavedata::create($validatedData);

        // 4. Redirect
        return redirect()->route('cnsd.save_data')->with('success', 'Data berhasil disimpan!');
    }

    public function update(Request $request, $id)
    {
        $savedData = CnsdSavedata::find($id);
        if (!$savedData) {
            return redirect()->route('cnsd.save_data')->withErrors('Data tidak ditemukan!');
        }

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

        // 4. Redirect
        return redirect()->route('cnsd.save_data')->with('success', 'Data berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $savedData = CnsdSavedata::find($id);
        if ($savedData) {
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

        // Cari kegiatan pertama yang cocok
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

    public function generatePdf($id) // <-- Signature asli tanpa PdfFactory
    {
        // Pastikan 'use niklasravnsborg\LaravelPdf\Facades\Pdf;' ada di atas class

        Log::info('--- PDF Generation START (using mPDF Facade) --- ID: ' . $id);

        try {
            // 1. Ambil data laporan tersimpan
            $savedData = CnsdSavedata::find($id);
            Log::info('1. SavedData fetched.', ['found' => !!$savedData]);

            // 2. Validasi
            if (!$savedData || $savedData->type !== 'Harian' || $savedData->print !== 'YA') {
                Log::error('2. Validation FAILED.', ['id' => $id, 'type' => $savedData?->type, 'print' => $savedData?->print]);
                return redirect()->route('cnsd.save_data')->withErrors('Laporan tidak ditemukan atau tidak valid untuk dicetak.');
            }
            Log::info('2. Validation PASSED.');

            // 3. Ambil data equipment
            $equipmentList = CnsdEquipment::orderBy('id', 'asc')->get();
            Log::info('3. Equipment fetched.', ['count' => $equipmentList->count()]);

            // 4. Ambil data jadwal/personel
            $schedule = SchedulesCnsd::where('tanggal', $savedData->tanggal->format('Y-m-d'))
                ->whereRaw('UPPER(dinas) = ?', [strtoupper($savedData->dinas)])
                ->first();
            Log::info('4a. Schedule fetched.', ['found' => !!$schedule]);

            $personnel = [];
            if ($schedule) {
                if (!empty($schedule->teknisi_1)) $personnel[] = $schedule->teknisi_1;
                if (!empty($schedule->teknisi_2)) $personnel[] = $schedule->teknisi_2;
                if (!empty($schedule->teknisi_3)) $personnel[] = $schedule->teknisi_3;
            }
            Log::info('4b. Personnel array created.', ['count' => count($personnel)]);

            // 5. Siapkan data untuk view PDF
            $data = [
                'tanggal' => $savedData->tanggal->format('d/m/Y'),
                'dinas' => $savedData->dinas,
                'equipmentList' => $equipmentList,
                'personnel' => $personnel,
                'mantekName' => $savedData->mantek,
            ];
            Log::info('5. Data prepared for view.');

            // 6. Load view PDF dan generate (menggunakan Facade mPDF wrapper)
            Log::info('6. Attempting Pdf::loadView (mPDF)...');
            // Gunakan Facade Pdf dengan method loadView() dan HAPUS setPaper()
            $pdf = Pdf::loadView('cnsd.report_pdf', $data); // <-- HAPUS ->setPaper(...)
            Log::info('6a. Pdf::loadView (mPDF) SUCCESS.');

            // 7. Tawarkan download atau tampilkan inline ke user
            $fileName = 'Laporan_Harian_CNSD_' . $savedData->tanggal->format('Ymd') . '_' . $savedData->dinas . '.pdf';
            $filePath = storage_path('app/temp/' . $fileName); // Simpan di storage/app/temp/

            // Pastikan folder temp ada dan writable
            if (!file_exists(storage_path('app/temp'))) {
                mkdir(storage_path('app/temp'), 0777, true); // 0777 untuk testing, idealnya lebih ketat
            }

            Log::info('7. Attempting save (mPDF) to: ' . $filePath);

            try {
                $pdf->save($filePath); // Coba simpan file
                Log::info('7a. Pdf::save (mPDF) SUCCESS.');
                // Jika berhasil disimpan, redirect atau beri pesan sukses
                return response('PDF disimpan sementara di server: ' . $fileName); // Beri feedback sederhana

            } catch (\Throwable $eSave) {
                // Jika save() gagal, catat error spesifik saat save
                Log::error('--- PDF Generation FAILED (mPDF save) --- Exception caught:', [
                    'message' => $eSave->getMessage(),
                    'file' => $eSave->getFile(),
                    'line' => $eSave->getLine(),
                ]);
                return redirect()->route('cnsd.save_data')->withErrors('Gagal menyimpan PDF (mPDF save): ' . $eSave->getMessage());
            }

            // Hapus return stream/download yang lama
            // return $pdf->stream($fileName);

        } catch (\Throwable $e) {
            // ... (catch block utama tetap sama) ...
            Log::error('--- PDF Generation FAILED (mPDF Facade - Outer Catch) --- Exception caught:', [ /*...*/]);
            return redirect()->route('cnsd.save_data')->withErrors('Gagal membuat PDF (mPDF Facade): ' . $e->getMessage());
        }
        // Nanti bisa ditambah method lain (create, store, edit, update, destroy)
    }

    public function previewPdf($id)
    {
        Log::info('--- PDF Preview START --- ID: ' . $id);

        try {
            // --- (Salin kode ambil data dari generatePdf) ---
            // 1. Ambil data laporan tersimpan
            $savedData = CnsdSavedata::find($id);
            Log::info('Preview - 1. SavedData fetched.', ['found' => !!$savedData]);

            // 2. Validasi (Sama seperti generatePdf, atau bisa dilonggarkan jika perlu)
            if (!$savedData || $savedData->type !== 'Harian' /* || $savedData->print !== 'YA' */) { // Komen 'print' jika mau preview meski Print=TIDAK
                Log::error('Preview - 2. Validation FAILED.', ['id' => $id, 'type' => $savedData?->type, 'print' => $savedData?->print]);
                return redirect()->route('cnsd.save_data')->withErrors('Laporan tidak ditemukan atau tidak valid untuk preview.');
            }
            Log::info('Preview - 2. Validation PASSED.');

            // 3. Ambil data equipment
            $equipmentList = CnsdEquipment::orderBy('id', 'asc')->get();
            Log::info('Preview - 3. Equipment fetched.', ['count' => $equipmentList->count()]);

            // 4. Ambil data jadwal/personel
            $schedule = SchedulesCnsd::where('tanggal', $savedData->tanggal->format('Y-m-d'))
                ->whereRaw('UPPER(dinas) = ?', [strtoupper($savedData->dinas)])
                ->first();
            Log::info('Preview - 4a. Schedule fetched.', ['found' => !!$schedule]);

            $personnel = [];
            if ($schedule) {
                if (!empty($schedule->teknisi_1)) $personnel[] = $schedule->teknisi_1;
                if (!empty($schedule->teknisi_2)) $personnel[] = $schedule->teknisi_2;
                if (!empty($schedule->teknisi_3)) $personnel[] = $schedule->teknisi_3;
            }
            Log::info('Preview - 4b. Personnel array created.', ['count' => count($personnel)]);

            // 5. Siapkan data untuk view
            $data = [
                'tanggal' => $savedData->tanggal->format('d/m/Y'),
                'dinas' => $savedData->dinas,
                'equipmentList' => $equipmentList,
                'personnel' => $personnel,
                'mantekName' => $savedData->mantek,
            ];
            Log::info('Preview - 5. Data prepared for view.');
            // --- (Akhir salinan kode ambil data) ---

            // 6. Langsung return view-nya
            Log::info('Preview - 6. Returning view cnsd.report_pdf');
            return view('cnsd.report_pdf', $data); // <-- Langsung tampilkan view

        } catch (\Throwable $e) {
            Log::error('--- PDF Preview FAILED --- Exception caught:', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);
            // Redirect dengan pesan error jika pengambilan data gagal
            return redirect()->route('cnsd.save_data')->withErrors('Gagal memuat preview: ' . $e->getMessage());
        }
    }
}
