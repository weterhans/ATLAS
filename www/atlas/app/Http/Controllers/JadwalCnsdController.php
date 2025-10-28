<?php

namespace App\Http\Controllers;

// 1. Pastikan Model-nya di-'use'
use App\Models\SchedulesCnsd;
use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;

// 2. Pastikan nama Class-nya bener: JadwalCnsdController
class JadwalCnsdController extends Controller
{
    /**
     * Display a listing of the resource.
     * Tampilkan halaman list jadwal CNSD.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Ambil semua data jadwal
        $schedules = SchedulesCnsd::orderBy('tanggal', 'desc')->get();

        // Ambil semua user (nanti bisa difilter kalo perlu)
        // Kita ambil fullname saja dan urutkan
        $teknisiList = User::where('role', 'Teknisi') // <-- Filter hanya user dengan role 'TeknisiCNSD'
            ->whereNotNull('fullname')
            ->orderBy('fullname')
            ->pluck('fullname') // Cukup ambil namanya
            ->all(); // Jadi array biasa
        // ->pluck('fullname', 'fullname') hasilnya [ "Andi Julianto" => "Andi Julianto", "joko" => "joko", ...]

        // Kirim data jadwal DAN list teknisi ke view
        return view('cnsd.jadwal', [
            'schedules' => $schedules,
            'teknisiList' => $teknisiList
        ]); // <-- Kirim list teknisi
    }

    public function store(Request $request)
    {
        // 1. Validasi data dari form
        $validatedData = $request->validate([
            'schedule_id_custom' => 'required|string|unique:schedules_cnsd,schedule_id_custom', // Pastikan ID unik
            'tanggal' => 'required|date',
            'dinas' => 'required|string|in:Pagi,Siang,Malam',
            'teknisi_1' => 'required|string',
            'teknisi_2' => 'required|string',
            'teknisi_3' => 'required|string',
            'teknisi_4' => 'nullable|string', // Opsional
            'teknisi_5' => 'nullable|string', // Opsional
            'teknisi_6' => 'nullable|string', // Opsional
        ]);

        // 2. Tambahkan data yang nggak ada di form (Hari, Kode, Grup)
        try {
            // Ambil nama hari dari tanggal
            $validatedData['hari'] = Carbon::parse($validatedData['tanggal'])->isoFormat('dddd');
        } catch (\Exception $e) {
            // Handle jika format tanggal salah (seharusnya tidak terjadi karena validasi)
            $validatedData['hari'] = '-';
        }

        // Kode & Grup (sesuaikan jika perlu)
        $validatedData['kode'] = $validatedData['schedule_id_custom']; // Samakan dengan ID Jadwal
        $validatedData['grup'] = 'CNSD'; // Hardcode

        // 3. Simpan data ke database
        SchedulesCnsd::create($validatedData);

        // 4. Kembali ke halaman list jadwal dengan pesan sukses
        return redirect()->route('cnsd.jadwal')->with('success', 'Jadwal baru berhasil ditambahkan!');
    }

    public function edit(SchedulesCnsd $schedule)
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

    public function update(Request $request, SchedulesCnsd $schedule)
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
        return redirect()->route('cnsd.jadwal')->with('success', 'Jadwal berhasil diperbarui!');
    }
    // Nanti bisa ditambah method lain di sini:
    // public function create() { ... } // Buat nampilin form tambah
    // public function store(Request $request) { ... } // Buat nyimpen data baru
    // public function edit($id) { ... } // Buat nampilin form edit
    // public function update(Request $request, $id) { ... } // Buat update data
    // public function destroy($id) { ... } // Buat hapus data
}
