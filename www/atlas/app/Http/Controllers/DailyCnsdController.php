<?php

namespace App\Http\Controllers;

// 1. Pastikan Model-nya di-'use'
use App\Models\DailyCnsdReports; // <-- Pake Model yang ini
use Illuminate\Http\Request;
use App\Models\CnsdEquipment;
use App\Models\User;
use App\Models\SchedulesCnsd; // Untuk ambil jadwal dinas
use Illuminate\Support\Facades\DB; // Opsional, bisa berguna
use Illuminate\Support\Str; // Untuk slug equipment name
use Carbon\Carbon; // Untuk tanggal & waktu
use Illuminate\Validation\Rule;

class DailyCnsdController extends Controller
{
    /**
     * Tampilkan halaman list daily report CNSD.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // 2. Ambil data dari Model DailyCnsdReport
        //    Pastikan tabel 'daily_cnsd_reports' punya kolom 'tanggal'
        $reports = DailyCnsdReports::orderBy('tanggal', 'desc')->get();

        $equipmentList = CnsdEquipment::orderBy('id')->get();

        // Ambil daftar user (misal semua user, atau filter role tertentu)
        $userList = User::orderBy('fullname')->pluck('fullname', 'id')->all();
        // Misal cuma Teknisi + Supervisor
        // $userList = User::whereIn('role', ['Teknisi', 'Supervisor'])->orderBy('fullname')->pluck('fullname', 'id')->all();

        return view('cnsd.daily', [
            'reports' => $reports,
            'equipmentList' => $equipmentList, // <-- Kirim list equipment
            'userList' => $userList,       // <-- Kirim list user
        ]);
    }

    public function getSchedule(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date_format:Y-m-d',
            'dinas' => 'required|in:Pagi,Siang,Malam',
        ]);

        $schedule = SchedulesCnsd::where('tanggal', $request->tanggal)
            ->where('dinas', $request->dinas)
            ->first();

        if ($schedule) {
            // Gabungkan nama teknisi jadi satu string
            $teknisi = collect([
                $schedule->teknisi_1,
                $schedule->teknisi_2,
                $schedule->teknisi_3,
                $schedule->teknisi_4,
                $schedule->teknisi_5,
                $schedule->teknisi_6
            ])->filter()->map(function ($name, $index) {
                return ($index + 1) . ". " . $name; // Format: "1. Nama"
            })->implode("\n"); // Pisahkan dengan baris baru

            return response()->json(['success' => true, 'jadwal' => $teknisi]);
        } else {
            return response()->json(['success' => false, 'message' => 'Tidak ada jadwal untuk tanggal/shift ini.']);
        }
    }

    public function store(Request $request)
    {
        // 1. Validasi Input Dasar
        $validatedData = $request->validate([
            'report_id_custom' => 'required|string|unique:daily_cnsd_reports,report_id_custom',
            'tanggal' => 'required|date',
            'jam' => 'required|date_format:H:i',
            'dinas' => 'required|string|in:Pagi,Siang,Malam',
            'mantek' => 'required|string',
            'acknowledge' => 'nullable|string',
            'kode' => 'required|string', // Pastikan 'kode' dikirim dari form (mungkin hidden input)
            'jadwal_dinas' => 'nullable|string', // Pastikan 'jadwal_dinas' dikirim (mungkin hidden input)
            // Validasi equipment_status (minimal harus ada)
            'equipment_status' => 'required|array|min:1',
            'equipment_status.*.status' => 'required|string|in:NORMAL,GANGGUAN,U/S,SINGLE',
            'equipment_status.*.keterangan' => 'nullable|string',
        ]);

        // 2. Format Ulang Data Equipment Status
        //    Form mengirim array [key => [status => value, keterangan => value]]
        //    Kita hanya perlu array [key => [status => value, keterangan => value (jika ada)]]
        $formattedEquipmentStatus = [];
        foreach ($validatedData['equipment_status'] as $key => $details) {
            $statusData = ['status' => $details['status']];
            // Hanya tambahkan keterangan jika status bukan NORMAL dan keterangan diisi
            if ($details['status'] !== 'NORMAL' && !empty($details['keterangan'])) {
                $statusData['keterangan'] = $details['keterangan'];
            }
            $formattedEquipmentStatus[$key] = $statusData;
        }
        // Ganti data di validatedData dengan yang sudah diformat
        $validatedData['equipment_status'] = $formattedEquipmentStatus;


        // 3. Simpan data ke database
        DailyCnsdReports::create($validatedData);

        // 4. Kembali ke halaman list daily dengan pesan sukses
        return redirect()->route('cnsd.daily')->with('success', 'Daily report berhasil ditambahkan!');
    }
    public function edit(DailyCnsdReports $report)
    {
        // Ambil data yang dibutuhkan untuk form (sama seperti index)
        $equipmentList = CnsdEquipment::orderBy('id')->get();
        $userList = User::orderBy('fullname')->pluck('fullname', 'id')->all(); // Ambil ID sbg value

        // Kirim data report spesifik & list lain ke view 'cnsd.edit_daily'
        return view('cnsd.edit_daily', [
            'report' => $report, // Data report yg mau diedit
            'equipmentList' => $equipmentList,
            'userList' => $userList
        ]);
    }

    public function update(Request $request, DailyCnsdReports $report)
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
        return redirect()->route('cnsd.daily')->with('success', 'Daily report berhasil diperbarui!');
    }

    // Nanti bisa ditambah method lain (create, store, edit, update, destroy)
}
