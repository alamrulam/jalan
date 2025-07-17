<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\ProfilPerusahaan;
use Illuminate\Http\Request;

class ProfilPerusahaanController extends Controller
{
    // Menampilkan form untuk mengedit profil perusahaan
    public function edit(Project $project)
    {
        // Cari profil yang ada, atau buat instance baru jika belum ada
        $profil = $project->profilPerusahaan ?? new ProfilPerusahaan();
        return view('admin.profil.edit', compact('project', 'profil'));
    }

    // Menyimpan atau mengupdate profil perusahaan
    public function update(Request $request, Project $project)
    {
        $validatedData = $request->validate([
            'nama_lembaga' => 'required|string|max:255',
            'alamat' => 'required|string',
            'nama_ketua' => 'required|string|max:255',
            'kontak' => 'nullable|string|max:20',
        ]);

        // Gunakan updateOrCreate untuk menangani kasus tambah baru atau update
        $project->profilPerusahaan()->updateOrCreate(
            ['project_id' => $project->id], // Kondisi pencarian
            $validatedData // Data untuk diisi atau diupdate
        );

        return redirect()->route('admin.projects.show', $project->id)->with('success', 'Profil perusahaan berhasil diperbarui.');
    }
}
