<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TenagaKerja;
use App\Models\Project; // Jangan lupa import Project
use Illuminate\Http\Request;

class TenagaKerjaController extends Controller
{
    public function index(Project $project)
    {
        $tenagaKerja = $project->tenagaKerja()->latest()->paginate(10);
        return view('admin.tenaga_kerja.index', compact('project', 'tenagaKerja'));
    }

    public function create(Project $project)
    {
        return view('admin.tenaga_kerja.create', compact('project'));
    }

    public function store(Request $request, Project $project)
    {
        $validatedData = $request->validate([
            'nama_pekerja' => 'required|string|max:255',
            'posisi' => 'required|string|max:100',
            'alamat_pekerja' => 'nullable|string',
            'honor_harian' => 'required|numeric|min:0',
        ]);

        $project->tenagaKerja()->create($validatedData);

        return redirect()->route('admin.projects.tenaga-kerja.index', $project->id)
            ->with('success', 'Tenaga kerja berhasil ditambahkan.');
    }

    public function edit(Project $project, TenagaKerja $tenagaKerja)
    {
        return view('admin.tenaga_kerja.edit', compact('project', 'tenagaKerja'));
    }

    public function update(Request $request, Project $project, TenagaKerja $tenagaKerja)
    {
        $validatedData = $request->validate([
            'nama_pekerja' => 'required|string|max:255',
            'posisi' => 'required|string|max:100',
            'alamat_pekerja' => 'nullable|string',
            'honor_harian' => 'required|numeric|min:0',
        ]);

        $tenagaKerja->update($validatedData);

        return redirect()->route('admin.projects.tenaga-kerja.index', $project->id)
            ->with('success', 'Data tenaga kerja berhasil diperbarui.');
    }

    public function destroy(Project $project, TenagaKerja $tenagaKerja)
    {
        $tenagaKerja->delete();

        return redirect()->route('admin.projects.tenaga-kerja.index', $project->id)
            ->with('success', 'Data tenaga kerja berhasil dihapus.');
    }
}
