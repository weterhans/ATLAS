<?php

namespace App\Http\Controllers;

// 1. Pastikan Model-nya di-'use'
use App\Models\SchedulesTfp; // <-- Pake Model TFP
use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;

class JadwalTfpController extends Controller
{
    /**
     * Tampilkan halaman list jadwal TFP.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // 2. Ambil data dari Model ScheduleTfp, urutkan
        $schedules = SchedulesTfp::orderBy('tanggal', 'desc')->get();

        $teknisiList = User::where('role', 'Teknisi') // <-- Filter role
            ->whereNotNull('fullname')
            ->orderBy('fullname')
            ->pluck('fullname') // Ambil namanya saja
            ->all();

        // 3. Kirim data ke view 'tfp.jadwal'
        return view('tfp.jadwal', [
            'schedules' => $schedules,
            'teknisiList' => $teknisiList // <-- Kirim list teknisi
        ]);
    }

    // Tambahkan use Carbon di atas class controller jika belum ada
    // use Carbon\Carbon;

    public function store(Request $request)
    {
        // 1. Validasi
        $validatedData = $request->validate([
            'schedule_id_custom' => 'required|string|unique:schedules_tfp,schedule_id_custom', // Cek ke tabel TFP
            'tanggal' => 'required|date',
            'dinas' => 'required|string|in:Pagi,Siang,Malam',
            'teknisi_1' => 'required|string',
            'teknisi_2' => 'required|string',
            'teknisi_3' => 'required|string',
            'teknisi_4' => 'nullable|string',
            'teknisi_5' => 'nullable|string',
            'teknisi_6' => 'nullable|string',
        ]);

        // 2. Tambah Hari, Kode, Grup
        try {
            $validatedData['hari'] = Carbon::parse($validatedData['tanggal'])->isoFormat('dddd');
        } catch (\Exception $e) {
            $validatedData['hari'] = '-';
        }
        $validatedData['kode'] = $validatedData['schedule_id_custom'];
        $validatedData['grup'] = 'TFP'; // Grup jadi TFP

        // 3. Simpan ke database (tabel schedules_tfp)
        SchedulesTfp::create($validatedData);

        // 4. Redirect dengan pesan sukses
        return redirect()->route('tfp.jadwal')->with('success', 'Jadwal TFP baru berhasil ditambahkan!');
    }

    public function edit(SchedulesTfp $schedule)
    {
        // Ambil lagi daftar teknisi (sama seperti di index)
        $teknisiList = User::where('role', 'Teknisi')
                         ->orderBy('fullname')
                         ->pluck('fullname')
                         ->all();

        // Kirim data jadwal spesifik & list teknisi ke view 'cnsd.edit'
        return view('cnsd.edit', [
            'schedule' => $schedule, // Data jadwal yg mau diedit
            'teknisiList' => $teknisiList
        ]);
    }

    public function update(Request $request, SchedulesTfp $schedule)
    {
        // 1. Validasi data (mirip store, tapi ID jadwal tidak perlu unique lagi)
        $validatedData = $request->validate([
            // schedule_id_custom & kode tidak perlu divalidasi/diupdate? (Biasanya tidak)
            'tanggal' => 'required|date',
            'dinas' => 'required|string|in:Pagi,Siang,Malam',
            'teknisi_1' => 'required|string',
            'teknisi_2' => 'required|string',
            'teknisi_3' => 'required|string',
            'teknisi_4' => 'nullable|string',
            'teknisi_5' => 'nullable|string',
            'teknisi_6' => 'nullable|string',
        ]);

        // 2. Tambah/Update data 'hari'
        try {
            $validatedData['hari'] = Carbon::parse($validatedData['tanggal'])->isoFormat('dddd');
        } catch (\Exception $e) {
             $validatedData['hari'] = $schedule->hari; // Pakai hari yg lama jika tanggal error
        }
        // ID Jadwal & Kode bisa di-update juga jika perlu (contoh: regenerate ID)
        // $validatedData['schedule_id_custom'] = ...
        // $validatedData['kode'] = ...

        // 3. Update data di database
        $schedule->update($validatedData);

        // 4. Kembali ke halaman list jadwal dengan pesan sukses
        return redirect()->route('tfp.jadwal')->with('success', 'Jadwal berhasil diperbarui!');
    }
}
