<?php

namespace App\Http\Controllers\Pelaksana;

use App\Http\Controllers\Controller;
use App\Models\DailyReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $pelaksana = Auth::user();

        // Kartu Statistik
        $assignedProjectsCount = $pelaksana->assignedProjects()->count();
        $rejectedReportsCount = DailyReport::where('user_id', $pelaksana->id)
            ->where('status_laporan', 'rejected')
            ->count();
        $pendingReportsCount = DailyReport::where('user_id', $pelaksana->id)
            ->where('status_laporan', 'pending')
            ->count();

        // Daftar 5 Laporan Terbaru
        $recentReports = DailyReport::where('user_id', $pelaksana->id)
            ->with('project')
            ->latest('created_at')
            ->take(5)
            ->get();

        return view('pelaksana.dashboard', compact(
            'assignedProjectsCount',
            'rejectedReportsCount',
            'pendingReportsCount',
            'recentReports'
        ));
    }
}
