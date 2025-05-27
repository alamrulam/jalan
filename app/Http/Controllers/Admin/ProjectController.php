<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    /**
     * menampilkan daftar proyek
     */
    public function index()
    {
        $projects = Project::latest()->paginate(10);
        return view('admin.projects.index', compact('projects'));
    }

    /**
     * menampikan form untuk membuat proyek baru
     */
    public function create()
    {
        return view('admin.projects.create');
    }

    /**
     * menyimpan proyek baru ke database
     */
    public function store(Request $request)
    {
        $validateData = $request->validate([
            'nama_proyek' => 'required|string|max:255',
            'lokasi' => 'required|string|max:255',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'jenis_proyek' => 'required|string|max:100',

        ]);

        // Tambahkan ID admin yang membuat jika perlu
        // $validatedData['created_by_admin_id'] = Auth::id();

        Project::create($validateData);

        return redirect()->route('admin.projects.index')->with('success', 'proyek berhasil ditambahkan.');
    }

    /**
     * menampilkan detail proyek. ( belum beres )
     */
    public function show(Project $project)
    {
        return view('admin.projects.show', compact('project'));
    }

    /**
     * menampilkan form untuk mengedit proyek ( belum beres)
     */
    public function edit(Project $project)
    {
        return view('admin.projects.edit', compact('project'));
    }

    /**
     * mengupdate proyek di database ( belum beres)
     */
    public function update(Request $request, Project $project)
    {
        $validatedData = $request->validate([
            'nama_proyek' => 'required|string|max:255',
            'lokasi' => 'required|string|max:255',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'jenis_proyek' => 'required|string|max:100',
        ]);

        $project->update($validatedData);

        return redirect()->route('admin.projects.index')->with('success', 'Proyek berhasil diperbarui.');
    }

    /**
     * menghapus proyek di database. (belum beres)
     */
    public function destroy(Project $project)
    {
        $project->delete();
        return redirect()->route('admin.projects.index')->with('success', 'Proyek berhasil dihapus.');
    }
}
