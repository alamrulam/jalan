<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DailyReport; // Import model DailyReport
use Illuminate\Http\Request;
use App\Models\Project; // Pastikan ini sudah di-import

class DailyReportController extends Controller
{
    /**
     * Menampilkan daftar semua laporan harian.
     */
    public function index(Request $request)
    {
        // Query dasar untuk mengambil laporan dengan relasi proyek dan user (pelaksana)
        // Diurutkan berdasarkan tanggal laporan terbaru, kemudian ID terbaru
        $query = DailyReport::with(['project', 'user'])->latest('tanggal_laporan')->latest('id');

        // Implementasi Filter (Contoh sederhana)
        if ($request->has('status_laporan') && $request->status_laporan != '') {
            $query->where('status_laporan', $request->status_laporan);
        }

        if ($request->has('project_id') && $request->project_id != '') {
            $query->where('project_id', $request->project_id);
        }

        if ($request->has('tanggal_dari') && $request->tanggal_dari != '') {
            $query->whereDate('tanggal_laporan', '>=', $request->tanggal_dari);
        }

        if ($request->has('tanggal_sampai') && $request->tanggal_sampai != '') {
            $query->whereDate('tanggal_laporan', '<=', $request->tanggal_sampai);
        }

        $reports = $query->paginate(15); // Ambil data dengan paginasi

        // Ambil data semua proyek untuk filter dropdown
        $projects = Project::orderBy('nama_proyek')->get();

        // Kirim variabel $reports dan $projects ke view
        return view('admin.reports.index', compact('reports', 'projects'));
    }

    /**
     * Menampilkan detail laporan harian.
     */
    public function show(DailyReport $report) // Menggunakan Route Model Binding
    {
        // Eager load relasi untuk menghindari N+1 query problem di view
        $report->load(['project', 'user', 'reportItems']);

        return view('admin.reports.show', compact('report'));
    }

    // Method edit(), update() akan ditambahkan nanti untuk verifikasi.

    // Method show(), edit(), update(), destroy() akan ditambahkan nanti
    // untuk detail, verifikasi, dan mungkin penghapusan laporan.

    public function verify(DailyReport $report)
    {
        // Pastikan hanya laporan dengan status 'pending' atau 'rejected' yang bisa diverifikasi
        if (!in_array($report->status_laporan, ['pending', 'rejected'])) {
            return redirect()->route('admin.reports.show', $report->id)->with('error', 'Laporan ini tidak bisa diverifikasi karena statusnya bukan pending atau rejected.');
        }

        $report->status_laporan = 'verified';
        $report->catatan_admin = null; // Hapus catatan admin jika sebelumnya ditolak lalu diverifikasi
        $report->save();

        return redirect()->route('admin.reports.show', $report->id)->with('success', 'Laporan berhasil diverifikasi.');
    }

    // app/Http/Controllers/Admin/DailyReportController.php
// ...
public function reject(Request $request, DailyReport $report)
{
    // Pastikan hanya laporan dengan status 'pending' yang bisa ditolak
    // (atau sesuaikan logikanya jika laporan yang sudah terverifikasi bisa ditolak kembali)
    if ($report->status_laporan != 'pending') {
        return redirect()->route('admin.reports.show', $report->id)->with('error', 'Hanya laporan dengan status pending yang bisa ditolak.');
    }

    $request->validate([
        'catatan_admin' => 'required|string|min:10', // Alasan penolakan wajib diisi
    ]);

    $report->status_laporan = 'rejected';
    $report->catatan_admin = $request->catatan_admin;
    $report->save();

    return redirect()->route('admin.reports.show', $report->id)->with('success', 'Laporan berhasil ditolak dengan catatan.');
}
}
