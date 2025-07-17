<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JenisPekerjaan;
use App\Models\Project;
use Illuminate\Http\Request;

class JenisPekerjaanController extends Controller
{
    public function index(Project $project)
    {
        $jenisPekerjaan = $project->jenisPekerjaan()->latest()->paginate(10);
        return view('admin.jenis_pekerjaan.index', compact('project', 'jenisPekerjaan'));
    }

    public function create(Project $project)
    {
        return view('admin.jenis_pekerjaan.create', compact('project'));
    }

    public function store(Request $request, Project $project)
    {
        $validatedData = $request->validate([
            'nama_pekerjaan' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'progres' => 'required|integer|min:0|max:100',
        ]);

        $project->jenisPekerjaan()->create($validatedData);

        return redirect()->route('admin.projects.jenis-pekerjaan.index', $project->id)
            ->with('success', 'Jenis pekerjaan berhasil ditambahkan.');
    }

    public function edit(Project $project, JenisPekerjaan $jenisPekerjaan)
    {
        return view('admin.jenis_pekerjaan.edit', compact('project', 'jenisPekerjaan'));
    }

    public function update(Request $request, Project $project, JenisPekerjaan $jenisPekerjaan)
    {
        $validatedData = $request->validate([
            'nama_pekerjaan' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'progres' => 'required|integer|min:0|max:100',
        ]);

        $jenisPekerjaan->update($validatedData);

        return redirect()->route('admin.projects.jenis-pekerjaan.index', $project->id)
            ->with('success', 'Data jenis pekerjaan berhasil diperbarui.');
    }

    public function destroy(Project $project, JenisPekerjaan $jenisPekerjaan)
    {
        // Tambahkan validasi untuk mencegah penghapusan jika sudah ada pembayaran terkait
        if ($jenisPekerjaan->pembayaran()->exists()) {
            return back()->with('error', 'Jenis pekerjaan ini tidak bisa dihapus karena sudah memiliki data pembayaran terkait.');
        }

        $jenisPekerjaan->delete();

        return redirect()->route('admin.projects.jenis-pekerjaan.index', $project->id)
            ->with('success', 'Data jenis pekerjaan berhasil dihapus.');
    }
}
