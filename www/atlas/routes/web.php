<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HarianCnsdController;
use App\Http\Controllers\HarianTfpController;
use App\Http\Controllers\JadwalCnsdController;
use App\Http\Controllers\DailyCnsdController;
use App\Http\Controllers\KegiatanCnsdController;
use App\Http\Controllers\SaveDataCnsdController;
use App\Http\Controllers\JadwalTfpController;
use App\Http\Controllers\DailyTfpController;
use App\Http\Controllers\KegiatanTfpController;
use App\Http\Controllers\SaveDataTfpController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/harian-cnsd', [HarianCnsdController::class, 'index'])->name('cnsd.index');
    Route::get('/harian-tfp', [HarianTfpController::class, 'index'])->name('tfp.index');

    // Untuk halaman Harian CNSD
    Route::get('/jadwal-cnsd', [JadwalCnsdController::class, 'index'])->name('cnsd.jadwal');
    Route::post('/jadwal-cnsd', [JadwalCnsdController::class, 'store'])->name('cnsd.jadwal.store');
    Route::get('/jadwal-cnsd/{schedule}/edit', [JadwalCnsdController::class, 'edit'])->name('cnsd.jadwal.edit');
    Route::put('/jadwal-cnsd/{schedule}', [JadwalCnsdController::class, 'update'])->name('cnsd.jadwal.update');
    Route::get('/daily-cnsd', [DailyCnsdController::class, 'index'])->name('cnsd.daily');
    Route::get('/daily-cnsd/get-schedule', [DailyCnsdController::class, 'getSchedule'])->name('cnsd.daily.getSchedule');
    Route::post('/daily-cnsd', [DailyCnsdController::class, 'store'])->name('cnsd.daily.store');
    Route::get('/daily-cnsd/{report}/edit', [DailyCnsdController::class, 'edit'])->name('cnsd.daily.edit');
    Route::put('/daily-cnsd/{report}', [DailyCnsdController::class, 'update'])->name('cnsd.daily.update');
    Route::get('/kegiatan-cnsd', [KegiatanCnsdController::class, 'index'])->name('cnsd.kegiatan');
    Route::get('/kegiatan-cnsd/get-teknisi', [KegiatanCnsdController::class, 'getScheduleTeknisi'])->name('cnsd.kegiatan.getTeknisi');
    Route::post('/kegiatan-cnsd', [KegiatanCnsdController::class, 'store'])->name('cnsd.kegiatan.store');
    Route::get('/kegiatan-cnsd/{activity}/edit', [KegiatanCnsdController::class, 'edit'])->name('cnsd.kegiatan.edit');
    Route::put('/kegiatan-cnsd/{activity}', [KegiatanCnsdController::class, 'update'])->name('cnsd.kegiatan.update');
    Route::get('/save-data-cnsd', [SaveDataCnsdController::class, 'index'])->name('cnsd.save_data');
    Route::post('/save-data-cnsd', [SaveDataCnsdController::class, 'store'])->name('cnsd.save_data.store');
    Route::get('/save-data-cnsd/get-related-activity', [SaveDataCnsdController::class, 'getRelatedActivity'])->name('cnsd.save_data.getActivity');
    Route::get('/cnsd/save-data/get-schedule', [SaveDataCnsdController::class, 'getRelatedSchedule'])->name('cnsd.save_data.getSchedule');
    Route::put('/cnsd/save-data/{id}', [SaveDataCnsdController::class, 'update'])->name('cnsd.save_data.update');
    Route::delete('/cnsd/save-data/{id}', [SaveDataCnsdController::class, 'destroy'])->name('cnsd.save_data.destroy');
    Route::get('/cnsd/save-data/get-range-activity', [SaveDataCnsdController::class, 'getActivitiesForDateRange'])->name('cnsd.save_data.getRangeActivity');
    Route::get('/cnsd/save-data/get-range-schedule', [SaveDataCnsdController::class, 'getSchedulesForDateRange'])->name('cnsd.save_data.getRangeSchedule');
    Route::get('/cnsd/save-data/{id}/pdf', [SaveDataCnsdController::class, 'generatePdf'])->name('cnsd.save_data.pdf');
    Route::get('/cnsd/save-data/{id}/preview', [SaveDataCnsdController::class, 'previewPdf'])->name('cnsd.save_data.preview');

    // Untuk Halaman HArian TFP
    Route::get('/jadwal-tfp', [JadwalTfpController::class, 'index'])->name('tfp.jadwal');
    Route::post('/jadwal-tfp', [JadwalTfpController::class, 'store'])->name('tfp.jadwal.store');
    Route::get('/jadwal-tfp/{schedule}/edit', [JadwalTfpController::class, 'edit'])->name('tfp.jadwal.edit');
    Route::put('/jadwal-tfp/{schedule}', [JadwalTfpController::class, 'update'])->name('tfp.jadwal.update');
    Route::get('/daily-tfp', [DailyTfpController::class, 'index'])->name('tfp.daily');
    Route::get('/daily-tfp/get-schedule', [DailyTfpController::class, 'getSchedule'])->name('tfp.daily.getSchedule');
    Route::post('/daily-tfp', [DailyTfpController::class, 'store'])->name('tfp.daily.store');
    Route::get('/daily-tfp/{report}/edit', [DailyTfpController::class, 'edit'])->name('tfp.daily.edit');
    Route::put('/daily-tfp/{report}', [DailyTfpController::class, 'update'])->name('tfp.daily.update');
    Route::get('/kegiatan-tfp', [KegiatanTfpController::class, 'index'])->name('tfp.kegiatan');
    Route::get('/kegiatan-tfp/get-teknisi', [KegiatanTfpController::class, 'getScheduleTeknisi'])->name('tfp.kegiatan.getTeknisi');
    Route::post('/kegiatan-tfp', [KegiatanTfpController::class, 'store'])->name('tfp.kegiatan.store');
    Route::get('/kegiatan-tfp/{activity}/edit', [KegiatanTfpController::class, 'edit'])->name('tfp.kegiatan.edit');
    Route::put('/kegiatan-tfp/{activity}', [KegiatanTfpController::class, 'update'])->name('tfp.kegiatan.update');
    Route::get('/save-data-tfp', [SaveDataTfpController::class, 'index'])->name('tfp.save_data');
});

require __DIR__ . '/auth.php';
