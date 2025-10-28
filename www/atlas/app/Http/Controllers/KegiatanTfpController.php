<?php

namespace App\Http\Controllers;

// 1. Pastikan Model-nya di-'use'
use App\Models\TfpActivities; // <-- Pake Model TFP Activity
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\SchedulesTfp;
use App\Models\TfpEquipment; // <-- Ganti ke Schedule TFP
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Validation\Rule;

class KegiatanTfpController extends Controller
{
    /**
     * Tampilkan halaman log kegiatan TFP.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // 2. Ambil data dari Model TfpActivity, urutkan
        $activities = TfpActivities::orderBy('tanggal', 'desc')
            ->orderBy('waktu_mulai', 'desc')
            ->get();

        // Ambil SEMUA user dengan role Teknisi
        $allTeknisi = User::where('role', 'Teknisi')
            ->orderBy('fullname')
            ->pluck('fullname')
            ->all();

        $equipmentList = TfpEquipment::orderBy('id')->get();

        $userList = User::orderBy('fullname')->pluck('fullname', 'id')->all();

        return view('tfp.kegiatan', [
            'activities' => $activities,
            'allTeknisi' => $allTeknisi,
            'equipmentList' => $equipmentList,
            'userList' => $userList // <-- Kirim list semua teknisi
        ]);
    }

    public function getScheduleTeknisi(Request $request)
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
            $teknisiOnDuty = collect([
                $schedule->teknisi_1,
                $schedule->teknisi_2,
                $schedule->teknisi_3,
                $schedule->teknisi_4,
                $schedule->teknisi_5,
                $schedule->teknisi_6
            ])->filter()->values()->all();

            return response()->json(['success' => true, 'teknisi' => $teknisiOnDuty]);
        } else {
            return response()->json(['success' => false, 'message' => 'Jadwal TFP tidak ditemukan.']);
        }
    }
    public function store(Request $request)
    {
        // 1. Validasi (mirip CNSD, sesuaikan nama unik jika perlu)
        $validatedData = $request->validate([
            'kode' => 'required|string|unique:tfp_activities,kode', // Cek ke tabel TFP
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
        ]);

        // 2. Proses Array Teknisi
        $validatedData['teknisi'] = array_filter($request->input('teknisi', []));

        // 3. Proses Upload Lampiran
        $lampiranPaths = [];
        if ($request->hasFile('lampiran')) {
            foreach ($request->file('lampiran') as $file) {
                if ($file->isValid()) {
                    // Simpan ke 'storage/app/public/lampiran_tfp'
                    $path = $file->store('lampiran_tfp', 'public'); // <-- Folder TFP
                    $lampiranPaths[] = $path;
                }
            }
        }
        $validatedData['lampiran'] = $lampiranPaths;

        // 4. Simpan ke Database (tabel tfp_activities)
        TfpActivities::create($validatedData);

        // 5. Redirect ke halaman list TFP kegiatan
        return redirect()->route('tfp.kegiatan')->with('success', 'Kegiatan TFP baru berhasil ditambahkan!');
    }

    public function edit(TfpActivities $activity) // <-- Ganti Model Binding
    {
        // Ambil SEMUA user dengan role Teknisi
        $allTeknisi = User::where('role', 'Teknisi')
            ->orderBy('fullname')
            ->pluck('fullname')
            ->all();

        // Kirim data ke view 'tfp.edit_kegiatan' (GANTI VIEW)
        return view('tfp.edit_kegiatan', [
            'activity' => $activity, // Data kegiatan TFP yg mau diedit
            'allTeknisi' => $allTeknisi
        ]);
    }

    public function update(Request $request, TfpActivities $activity) // <-- Ganti Model Binding
    {
        // 1. Validasi (Sama kayak CNSD)
        $validatedData = $request->validate([
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
            'delete_lampiran' => 'nullable|array',
            'delete_lampiran.*' => 'nullable|string',
        ]);

        // 2. Proses Array Teknisi
        $validatedData['teknisi'] = array_values(array_filter($request->input('teknisi', [])));

        // 3. PROSES LAMPIRAN
        $currentPaths = is_array($activity->lampiran) ? array_filter($activity->lampiran) : [];
        $pathsToDelete = $request->input('delete_lampiran', []);

        // Proses penghapusan file lama
        if (!empty($pathsToDelete)) {
            foreach ($pathsToDelete as $path) {
                if ($path && Storage::disk('public')->exists($path)) {
                    Storage::disk('public')->delete($path);
                }
                $key = array_search($path, $currentPaths);
                if ($key !== false) {
                    unset($currentPaths[$key]);
                }
            }
            $currentPaths = array_values($currentPaths);
        }

        // Proses penambahan file baru
        $newLampiranPaths = [];
        if ($request->hasFile('lampiran')) {
            foreach ($request->file('lampiran') as $file) {
                if ($file->isValid()) {
                    // Simpan ke 'storage/app/public/lampiran_tfp' (GANTI FOLDER)
                    $path = $file->store('lampiran_tfp', 'public');
                    $newLampiranPaths[] = $path;
                }
            }
        }

        // GABUNGKAN path
        $validatedData['lampiran'] = array_merge($currentPaths, $newLampiranPaths);

        // 4. Hapus 'delete_lampiran' dari data validasi
        unset($validatedData['delete_lampiran']);

        // 5. Update data di database
        $activity->update($validatedData);

        // 6. Redirect kembali dengan pesan sukses (GANTI ROUTE)
        return redirect()->route('tfp.kegiatan')->with('success', 'Kegiatan berhasil diperbarui!');
    }
}
