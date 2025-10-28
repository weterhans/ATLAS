<?php

namespace App\Http\Controllers;

// 1. Pastikan Model-nya di-'use'
use App\Models\DailyTfpReports; // <-- Pake Model TFP Report
use Illuminate\Http\Request;
use App\Models\TfpEquipment; // <-- Ganti jadi TFP Equipment
use App\Models\User;
use App\Models\SchedulesTfp; // <-- Ganti jadi TFP SchedulE
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class DailyTfpController extends Controller
{
    /**
     * Tampilkan halaman list daily report TFP.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // 2. Ambil data dari Model DailyTfpReport, urutkan
        $reports = DailyTfpReports::orderBy('tanggal', 'desc')->get();

        $equipmentList = TfpEquipment::orderBy('id')->get(); // <-- Ambil dari TfpEquipment

        // Ambil daftar user
        $userList = User::orderBy('fullname')->pluck('fullname', 'id')->all();

        return view('tfp.daily', [
            'reports' => $reports,
            'equipmentList' => $equipmentList, // <-- Kirim list TFP equipment
            'userList' => $userList,
        ]);
    }
    public function getSchedule(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date_format:Y-m-d',
            'dinas' => 'required|in:Pagi,Siang,Malam',
        ]);

        // Cari di tabel schedules_tfp
        $schedule = SchedulesTfp::where('tanggal', $request->tanggal)
            ->where('dinas', $request->dinas)
            ->first();

        if ($schedule) {
            $teknisi = collect([
                $schedule->teknisi_1,
                $schedule->teknisi_2,
                $schedule->teknisi_3,
                $schedule->teknisi_4,
                $schedule->teknisi_5,
                $schedule->teknisi_6
            ])->filter()->map(function ($name, $index) {
                return ($index + 1) . ". " . $name;
            })->implode("\n");

            return response()->json(['success' => true, 'jadwal' => $teknisi]);
        } else {
            return response()->json(['success' => false, 'message' => 'Tidak ada jadwal TFP untuk tanggal/shift ini.']);
        }
    }
    public function store(Request $request)
    {
        // Validasi (mirip CNSD, sesuaikan nama unik jika perlu)
        $validatedData = $request->validate([
            'report_id_custom' => 'required|string|unique:daily_tfp_reports,report_id_custom', // Cek ke tabel TFP
            'tanggal' => 'required|date',
            'jam' => 'required|date_format:H:i',
            'dinas' => 'required|string|in:Pagi,Siang,Malam',
            'mantek' => 'required|string',
            'acknowledge' => 'nullable|string',
            'kode' => 'required|string',
            'jadwal_dinas' => 'nullable|string',
            'equipment_status' => 'required|array|min:1',
            'equipment_status.*.status' => 'required|string|in:NORMAL,GANGGUAN,U/S,SINGLE', // Sesuaikan status TFP jika beda
            'equipment_status.*.keterangan' => 'nullable|string',
        ]);

        // Format Ulang Data Equipment Status (Sama kayak CNSD)
        $formattedEquipmentStatus = [];
        foreach ($validatedData['equipment_status'] as $key => $details) {
            $statusData = ['status' => $details['status']];
            if ($details['status'] !== 'NORMAL' && !empty($details['keterangan'])) {
                $statusData['keterangan'] = $details['keterangan'];
            }
            $formattedEquipmentStatus[$key] = $statusData;
        }
        $validatedData['equipment_status'] = $formattedEquipmentStatus;

        // Simpan ke database (tabel daily_tfp_reports)
        DailyTfpReports::create($validatedData);

        // Redirect ke halaman list TFP daily dengan pesan sukses
        return redirect()->route('tfp.daily')->with('success', 'Daily report TFP berhasil ditambahkan!');
    }

    public function edit(DailyTfpReports $report)
    {
        // Ambil data yang dibutuhkan untuk form (sama seperti index)
        $equipmentList = TfpEquipment::orderBy('id')->get();
        $userList = User::orderBy('fullname')->pluck('fullname', 'id')->all(); // Ambil ID sbg value

        // Kirim data report spesifik & list lain ke view 'cnsd.edit_daily'
        return view('tfp.edit_daily', [
            'report' => $report, // Data report yg mau diedit
            'equipmentList' => $equipmentList,
            'userList' => $userList
        ]);
    }

    public function update(Request $request, DailyTfpReports $report)
    {
        // 1. Validasi (mirip store, tapi unique ID diabaikan untuk report ini)
        $validatedData = $request->validate([
            // ID Custom tidak diupdate, tapi mungkin perlu divalidasi exist?
            // 'report_id_custom' => ['required','string', Rule::unique('daily_cnsd_reports')->ignore($report->id)],
            'tanggal' => 'required|date',
            'jam' => 'required|date_format:H:i',
            'dinas' => 'required|string|in:Pagi,Siang,Malam',
            'mantek' => 'required|string',
            'acknowledge' => 'nullable|string',
            'kode' => 'required|string',
            'jadwal_dinas' => 'nullable|string',
            'equipment_status' => 'required|array|min:1',
            'equipment_status.*.status' => 'required|string|in:NORMAL,GANGGUAN,U/S,SINGLE',
            'equipment_status.*.keterangan' => 'nullable|string',
        ]);

         // 2. Format Ulang Data Equipment Status (Sama seperti store)
        $formattedEquipmentStatus = [];
        // Pastikan $request->equipment_status tidak null sebelum di-loop
        foreach ($request->input('equipment_status', []) as $key => $details) {
            // Pastikan 'status' ada di dalam $details
            if (!isset($details['status'])) continue; // Lewati jika format salah

            $statusData = ['status' => $details['status']];
            if ($details['status'] !== 'NORMAL' && !empty($details['keterangan'])) {
                $statusData['keterangan'] = $details['keterangan'];
            }
            $formattedEquipmentStatus[$key] = $statusData;
        }
        $validatedData['equipment_status'] = $formattedEquipmentStatus;


        // 3. Update data di database
        $report->update($validatedData);

        // 4. Kembali ke halaman list daily dengan pesan sukses
        return redirect()->route('tfp.daily')->with('success', 'Daily report berhasil diperbarui!');
    }
}
