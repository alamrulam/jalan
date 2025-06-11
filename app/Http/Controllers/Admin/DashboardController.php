<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DailyReport;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Kartu Statistik
        $pendingReportsCount = DailyReport::where('status_laporan', 'pending')->count();
        $totalProjectsCount = Project::count();
        $totalPelaksanaCount = User::where('role', 'pelaksana')->count();

        // Data untuk Grafik Laporan per Status
        $reportStatusCounts = DailyReport::select('status_laporan', DB::raw('count(*) as total'))
            ->groupBy('status_laporan')
            ->pluck('total', 'status_laporan');

        $chartLabels = ['Pending', 'Terverifikasi', 'Ditolak'];
        $chartData = [
            $reportStatusCounts->get('pending', 0),
            $reportStatusCounts->get('verified', 0),
            $reportStatusCounts->get('rejected', 0),
        ];

        // Daftar 5 Laporan Terbaru
        $recentReports = DailyReport::with(['project', 'user'])
            ->latest('created_at')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'pendingReportsCount',
            'totalProjectsCount',
            'totalPelaksanaCount',
            'chartLabels',
            'chartData',
            'recentReports'
        ));
    }
}
