<?php

namespace App\Http\Controllers\Pelaksana;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Project; // Pastikan model Project di-import


class ProjectController extends Controller
{
    /**
     * Menampilkan daftar proyek yang ditugaskan kepada pelaksana yang sedang login.
     */
    public function index()
    {
        $pelaksana = Auth::user();
        // Ambil proyek yang terelasi dengan pelaksana ini melalui tabel pivot
        // Pastikan relasi 'assignedProjects' sudah didefinisikan di model User
        $assignedProjects = $pelaksana->assignedProjects()->latest('projects.created_at')->paginate(10);

        return view('pelaksana.projects.index', compact('assignedProjects'));
    }

    // Method untuk mengarahkan ke form pembuatan laporan (akan digunakan di Bagian 3)
    public function createReport(Project $project)
    {
        // Cek apakah proyek ini benar-benar ditugaskan ke pelaksana
        if (!Auth::user()->assignedProjects()->where('projects.id', $project->id)->exists()) {
            return redirect()->route('pelaksana.projects.index')->with('error', 'Anda tidak ditugaskan pada proyek ini.');
        }
        // Arahkan ke form laporan harian untuk $project->id
        // Rute ini akan dibuat di Bagian 3
        return redirect()->route('pelaksana.laporan.create', $project->id);
    }
}
