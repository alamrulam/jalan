<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pembayaran;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Kartu Statistik Baru
        $totalPengeluaran = Pembayaran::sum('jumlah');
        $totalProjectsCount = Project::count();
        $totalPelaksanaCount = User::where('role', 'pelaksana')->count();

        // Data untuk Grafik Baru: 5 Proyek dengan Pengeluaran Terbesar
        $topProjects = Project::withSum('pembayaran', 'jumlah')
            ->orderBy('pembayaran_sum_jumlah', 'desc')
            ->take(5)
            ->get();

        $chartLabels = $topProjects->pluck('nama_proyek');
        $chartData = $topProjects->pluck('pembayaran_sum_jumlah');

        // Daftar 5 Pembayaran Terbaru
        $recentPembayarans = Pembayaran::with(['project'])
            ->latest('tanggal_pembayaran')
            ->latest('id')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalPengeluaran',
            'totalProjectsCount',
            'totalPelaksanaCount',
            'chartLabels',
            'chartData',
            'recentPembayarans'
        ));
    }
}
