<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ProjectController; // <-- TAMBAHKAN IMPORT INI
use Illuminate\Support\Facades\Auth;             // <-- TAMBAHKAN IMPORT INI
use App\Http\Controllers\Pelaksana\ProjectController as PelaksanaProjectController;
use App\Http\Controllers\Pelaksana\DailyReportController as PelaksanaDailyReportController;
use App\Http\Controllers\Admin\DailyReportController as AdminDailyReportController;
use App\Http\Controllers\Admin\DashboardController; // Tambahkan ini di atas
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Pelaksana\DashboardController as PelaksanaDashboardController;
use App\Http\Controllers\Admin\ProfilPerusahaanController;
use App\Http\Controllers\Admin\TenagaKerjaController;
use App\Http\Controllers\Admin\JenisPekerjaanController;
use App\Http\Controllers\Pelaksana\PembayaranController;
use App\Http\Controllers\Admin\LaporanController;
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
    return view('welcome');
});

// MODIFIKASI RUTE DASHBOARD UNTUK ROLE REDIRECTION
Route::get('/dashboard', function () {
    // Pastikan user sudah login sebelum cek role
    // Middleware 'auth' sudah menangani ini, tapi double check tidak masalah
    if (Auth::check()) {
        if (Auth::user()->role == 'admin') {
            return redirect()->route('admin.dashboard');
        } elseif (Auth::user()->role == 'pelaksana') {
            return redirect()->route('pelaksana.dashboard'); // Arahkan pelaksana ke daftar proyeknya
        }
    }
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// TAMBAHKAN RUTE UNTUK MANAJEMEN PROYEK ADMIN DI SINI
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('projects', ProjectController::class);
    // Rute admin lainnya bisa ditambahkan di sini jika ada
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('users', UserController::class);
    Route::get('projects/{project}/profil/edit', [ProfilPerusahaanController::class, 'edit'])->name('profil.edit');
    Route::put('projects/{project}/profil', [ProfilPerusahaanController::class, 'update'])->name('profil.update');
    Route::resource('projects.tenaga-kerja', TenagaKerjaController::class)->except(['show']);
    Route::resource('projects.jenis-pekerjaan', JenisPekerjaanController::class)->except(['show']);
    Route::get('laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::post('laporan/export', [LaporanController::class, 'export'])->name('laporan.export');
});


// Route::middleware(['auth', 'pelaksana'])->prefix('pelaksana')->name('pelaksana.')->group(function () {
//     Route::get('proyek-saya', [PelaksanaProjectController::class, 'index'])->name('projects.index');
//     // Rute untuk form input laporan harian (akan dibuat di Bagian 3)
//     // Contoh: Route::get('proyek/{project}/laporan/buat', [NamaControllerLaporan::class, 'create'])->name('laporan.create');
// });

Route::middleware(['auth', 'pelaksana'])->prefix('pelaksana')->name('pelaksana.')->group(function () {
    Route::get('dashboard', [PelaksanaDashboardController::class, 'index'])->name('dashboard');
    Route::get('proyek-saya', [PelaksanaProjectController::class, 'index'])->name('projects.index');
    // Rute untuk form input laporan harian
    Route::get('proyek/{project}/laporan/buat', [PelaksanaDailyReportController::class, 'create'])->name('laporan.create');
    Route::post('proyek/{project}/laporan', [PelaksanaDailyReportController::class, 'store'])->name('laporan.store');
    // Rute untuk riwayat laporan pelaksana (nanti)
    // Route::get('laporan/riwayat', [PelaksanaDailyReportController::class, 'history'])->name('laporan.history');
    // Rute BARU untuk Riwayat Laporan Pelaksana
    Route::get('laporan-saya', [PelaksanaDailyReportController::class, 'history'])->name('reports.history');
    // Rute opsional untuk detail laporan pelaksana
    Route::get('laporan-saya/{report}', [PelaksanaDailyReportController::class, 'showReportDetail'])->name('reports.showDetail');
    Route::get('laporan-saya/{report}/edit-revisi', [PelaksanaDailyReportController::class, 'editRevision'])->name('reports.editRevision');
    Route::put('laporan-saya/{report}/update-revisi', [PelaksanaDailyReportController::class, 'updateRevision'])->name('reports.updateRevision');
    Route::resource('projects.pembayaran', PembayaranController::class);
});

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('projects', ProjectController::class); // Ini sudah ada dari Bagian 1
    Route::resource('reports', AdminDailyReportController::class)->only(['index', 'show', 'edit', 'update']); // Fokus pada index dulu, lalu show, edit, update
    // Anda bisa menambahkan rute lain yang spesifik di sini jika perlu
    // Misalnya: Route::post('reports/{report}/verify', [AdminDailyReportController::class, 'verify'])->name('reports.verify');
    Route::post('reports/{report}/verify', [AdminDailyReportController::class, 'verify'])->name('reports.verify');
    Route::post('reports/{report}/reject', [AdminDailyReportController::class, 'reject'])->name('reports.reject');

    // Rute baru untuk Ekspor PDF Laporan Harian
    Route::get('reports/export/pdf', [AdminDailyReportController::class, 'exportPdf'])->name('reports.export.pdf');

    // Rute baru untuk Ekspor Excel Laporan Harian
    Route::get('reports/export/excel', [AdminDailyReportController::class, 'exportExcel'])->name('reports.export.excel');
});
require __DIR__ . '/auth.php';
