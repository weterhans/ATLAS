<?php

namespace App\Http\Controllers;

// 1. Pastikan Model-nya di-'use'
use App\Models\User;
use App\Models\CnsdActivities; // <-- Pake Model yang ini
use Illuminate\Http\Request;
use App\Models\SchedulesCnsd;
use Illuminate\Support\Facades\Storage; // <-- Untuk file upload
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Validation\Rule;

class KegiatanCnsdController extends Controller
{
    /**
     * Tampilkan halaman log kegiatan CNSD.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // 2. Ambil data dari Model CnsdActivity
        //    Urutkan berdasarkan tanggal & waktu mulai terbaru
        $activities = CnsdActivities::orderBy('tanggal', 'desc')
            ->orderBy('waktu_mulai', 'desc')
            ->get();

        $allTeknisi = User::where('role', 'Teknisi')
            ->orderBy('fullname')
            ->pluck('fullname') // Ambil namanya saja
            ->all();

        // 3. Kirim data ke view 'cnsd.kegiatan'
        return view('cnsd.kegiatan', [
            'activities' => $activities, // Kirim data dgn nama variabel 'activities'
            'allTeknisi' => $allTeknisi
        ]);
    }

    public function getScheduleTeknisi(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date_format:Y-m-d',
            'dinas' => 'required|in:Pagi,Siang,Malam',
        ]);

        $schedule = SchedulesCnsd::where('tanggal', $request->tanggal)
            ->where('dinas', $request->dinas)
            ->first();

        if ($schedule) {
            // Ambil nama teknisi yang ada di jadwal itu
            $teknisiOnDuty = collect([
                $schedule->teknisi_1,
                $schedule->teknisi_2,
                $schedule->teknisi_3,
                $schedule->teknisi_4,
                $schedule->teknisi_5,
                $schedule->teknisi_6
            ])->filter()->values()->all(); // filter() hapus yg null, values() reset index

            return response()->json(['success' => true, 'teknisi' => $teknisiOnDuty]);
        } else {
            return response()->json(['success' => false, 'message' => 'Jadwal tidak ditemukan.']);
        }
    }

    public function store(Request $request)
    {
        // 1. Validasi
        $validatedData = $request->validate([
            'kode' => 'required|string|unique:cnsd_activities,kode',
            'dinas' => 'required|string|in:Pagi,Siang,Malam',
            'tanggal' => 'required|date',
            'waktu_mulai' => 'required|date_format:H:i',
            'waktu_selesai' => 'required|date_format:H:i|after:waktu_mulai',
            'alat' => 'required|string|max:255',
            'permasalahan' => 'required|string',
            'tindakan' => 'required|string',
            'hasil' => 'required|string',
            'status' => 'required|string|max:50',
            'waktu_terputus' => 'nullable|string|max:100',
            'teknisi' => 'required|array|min:1', // Pastikan minimal ada 1 teknisi
            'teknisi.*' => 'nullable|string', // Tiap item di array teknisi boleh null/string
            'lampiran.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx,xls,xlsx|max:5120', // Maks 5MB per file
        ]);

        // 2. Proses Array Teknisi (Hapus yang kosong)
        $validatedData['teknisi'] = array_filter($request->input('teknisi', [])); // Ambil dari input, filter yg kosong

        // 3. Proses Upload Lampiran
        $lampiranPaths = [];
        if ($request->hasFile('lampiran')) {
            foreach ($request->file('lampiran') as $file) {
                if ($file->isValid()) {
                    // Simpan ke 'storage/app/public/lampiran_cnsd'
                    $path = $file->store('lampiran_cnsd', 'public');
                    $lampiranPaths[] = $path; // Simpan path-nya
                }
            }
        }
        $validatedData['lampiran'] = $lampiranPaths; // Masukkan array path ke data

        // 4. Simpan ke Database
        CnsdActivities::create($validatedData);

        // 5. Redirect kembali dengan pesan sukses
        return redirect()->route('cnsd.kegiatan')->with('success', 'Kegiatan baru berhasil ditambahkan!');
    }

    public function edit(CnsdActivities $activity) // Route Model Binding
    {
        // Ambil SEMUA user dengan role Teknisi
        $allTeknisi = User::where('role', 'Teknisi')
            ->orderBy('fullname')
            ->pluck('fullname')
            ->all();

        // Kirim data kegiatan spesifik & list teknisi ke view 'cnsd.edit_kegiatan'
        return view('cnsd.edit_kegiatan', [
            'activity' => $activity, // Data kegiatan yg mau diedit
            'allTeknisi' => $allTeknisi
        ]);
    }

    public function update(Request $request, CnsdActivities $activity) // Route Model Binding
    {
        // 1. Validasi (mirip store, tapi unique kode diabaikan untuk record ini)
        $validatedData = $request->validate([
            // 'kode' => ['required','string', Rule::unique('cnsd_activities')->ignore($activity->id)], // Kode biasanya tidak diubah
            'dinas' => 'required|string|in:Pagi,Siang,Malam',
            'tanggal' => 'required|date',
            'waktu_mulai' => 'required|date_format:H:i',
            'waktu_selesai' => 'required|date_format:H:i|after:waktu_mulai',
            'alat' => 'required|string|max:255',
            'permasalahan' => 'required|string',
            'tindakan' => 'required|string',
            'hasil' => 'required|string',
            'status' => 'required|string|max:50',
            'waktu_terputus' => 'nullable|string|max:100',
            'teknisi' => 'required|array|min:1',
            'teknisi.*' => 'nullable|string',
            'lampiran.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx,xls,xlsx|max:5120',
            // Tambahan untuk hapus lampiran lama (jika perlu)
            'delete_lampiran' => 'nullable|array',
            'delete_lampiran.*' => 'nullable|string', // Isinya path file yg mau dihapus
        ]);

        // 2. Proses Array Teknisi (Hapus yang kosong/null)
        $validatedData['teknisi'] = array_values(array_filter($request->input('teknisi', []))); // Pakai array_values agar index rapi

        // ====================================================================
        // 3. PROSES LAMPIRAN (LOGIKA BARU YANG SUDAH DIPERBAIKI)
        // ====================================================================

        // Ambil path lampiran yg ada di database SEKARANG
        // Pastikan $currentPaths adalah array, bahkan jika $activity->lampiran null
        $currentPaths = is_array($activity->lampiran) ? array_filter($activity->lampiran) : [];

        // Ambil path yg ingin dihapus dari form (checkbox)
        $pathsToDelete = $request->input('delete_lampiran', []);

        // Proses penghapusan file lama (jika ada yg dicentang)
        if (!empty($pathsToDelete)) {
            foreach ($pathsToDelete as $path) {
                // Hapus file dari storage
                if ($path && Storage::disk('public')->exists($path)) {
                    Storage::disk('public')->delete($path);
                }
                
                // Hapus path ini dari array $currentPaths
                $key = array_search($path, $currentPaths);
                if ($key !== false) {
                    unset($currentPaths[$key]);
                }
            }
            // Rapikan index array setelah unset
            $currentPaths = array_values($currentPaths);
        }

        // Proses penambahan file baru (jika ada yg diupload)
        $newLampiranPaths = [];
        if ($request->hasFile('lampiran')) {
            foreach ($request->file('lampiran') as $file) {
                if ($file->isValid()) {
                    $path = $file->store('lampiran_cnsd', 'public');
                    $newLampiranPaths[] = $path; // Kumpulkan path baru
                }
            }
        }

        // GABUNGKAN path lama (yg tidak dihapus) dengan path baru
        // Ini akan jadi data baru untuk kolom 'lampiran'
        $validatedData['lampiran'] = array_merge($currentPaths, $newLampiranPaths);

        // ====================================================================
        // 4. FIX UTAMA: Hapus 'delete_lampiran' dari data validasi
        // ====================================================================
        // Ini HARUS dilakukan di luar if/else, biar nggak ikut ke query 'update'
        unset($validatedData['delete_lampiran']);


        // 5. Update data di database
        // Hanya field yg ada di $validatedData yg akan diupdate
        $activity->update($validatedData);

        // 6. Redirect kembali dengan pesan sukses
        return redirect()->route('cnsd.kegiatan')->with('success', 'Kegiatan berhasil diperbarui!');
    }

    // Nanti bisa ditambah method lain (create, store, edit, update, destroy)
}
