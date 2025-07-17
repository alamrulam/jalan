<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
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
        $validatedData = $request->validate([
            'nama_proyek' => 'required|string|max:255',
            'kecamatan' => 'required|string|max:255', // Validasi untuk kecamatan
            'desa' => 'required|string|max:255',      // Validasi untuk desa
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'jenis_proyek' => 'required|string|max:255',
        ]);

        // Tambahkan ID admin yang membuat jika perlu
        // $validatedData['created_by_admin_id'] = Auth::id();

        Project::create([
            'nama_proyek' => $validatedData['nama_proyek'],
            'lokasi' => $validatedData['kecamatan'] . ', ' . $validatedData['desa'], // Gabungkan kecamatan dan desa
            'tanggal_mulai' => $validatedData['tanggal_mulai'],
            'tanggal_selesai' => $validatedData['tanggal_selesai'],
            'jenis_proyek' => $validatedData['jenis_proyek'],
        ]);

        return redirect()->route('admin.projects.index')->with('success', 'Proyek berhasil ditambahkan.');
    }



    public function show(Project $project)
    {
        // Eager load relasi untuk menghindari N+1 query problem
        $project->load(['assignedUsers', 'profilPerusahaan', 'tenagaKerja']);
        return view('admin.projects.show', compact('project'));
    }

    /**
     * Menampilkan form untuk mengedit proyek.
     */
    public function edit(Project $project)
    {
        $pelaksanas = User::where('role', 'pelaksana')->orderBy('name')->get();
        $assignedPelaksanaIds = $project->assignedUsers()->pluck('users.id')->toArray();

        // Pecah lokasi menjadi kecamatan dan desa untuk form edit
        $lokasiParts = explode(', ', $project->lokasi);
        $kecamatan = $lokasiParts[0] ?? '';
        $desa = $lokasiParts[1] ?? '';

        return view('admin.projects.edit', compact('project', 'pelaksanas', 'assignedPelaksanaIds', 'kecamatan', 'desa'));
    }
    /**
     * Mengupdate proyek di database.
     */
    public function update(Request $request, Project $project)
    {
        $validatedData = $request->validate([
            'nama_proyek' => 'required|string|max:255',
            'kecamatan' => 'required|string|max:255',
            'desa' => 'required|string|max:255',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'jenis_proyek' => 'required|string|max:255',
            'pelaksana_ids' => 'nullable|array',
            'pelaksana_ids.*' => ['nullable', 'integer', Rule::exists('users', 'id')->where('role', 'pelaksana')],
        ]);

        // Update data utama proyek
        $project->update([
            'nama_proyek' => $validatedData['nama_proyek'],
            'lokasi' => $validatedData['kecamatan'] . ', ' . $validatedData['desa'],
            'tanggal_mulai' => $validatedData['tanggal_mulai'],
            'tanggal_selesai' => $validatedData['tanggal_selesai'],
            'jenis_proyek' => $validatedData['jenis_proyek'],
        ]);

        // Sinkronisasi pelaksana yang ditugaskan
        // Method sync() akan menghapus penugasan lama dan menambahkan yang baru.
        // Jika 'pelaksana_ids' tidak ada di request (misal tidak ada yg dipilih),
        // kirim array kosong agar semua penugasan dihapus.
        $project->assignedUsers()->sync($request->input('pelaksana_ids', []));

        return redirect()->route('admin.projects.index')->with('success', 'Proyek berhasil diperbarui beserta penugasan pelaksananya.');
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
