<?php

namespace App\Http\Controllers\Pelaksana;

use App\Http\Controllers\Controller;
use App\Models\Pembayaran;
use App\Models\Project;
use Illuminate\Http\Request;

class PembayaranController extends Controller
{
    public function index(Project $project)
    {
        // Pastikan pelaksana hanya bisa mengakses proyek yang ditugaskan padanya
        // Logika ini bisa ditambahkan jika diperlukan
        $pembayarans = $project->pembayaran()->with('jenisPekerjaan')->latest()->paginate(15);
        return view('pelaksana.pembayaran.index', compact('project', 'pembayarans'));
    }

    public function create(Project $project)
    {
        // Ambil jenis pekerjaan untuk dropdown
        $jenisPekerjaanOptions = $project->jenisPekerjaan()->pluck('nama_pekerjaan', 'id');
        return view('pelaksana.pembayaran.create', compact('project', 'jenisPekerjaanOptions'));
    }

    public function store(Request $request, Project $project)
    {
        $validatedData = $request->validate([
            'jenis_pekerjaan_id' => 'required|exists:jenis_pekerjaans,id',
            'tanggal_pembayaran' => 'required|date',
            'jenis_transaksi' => 'required|string|max:255',
            'keterangan' => 'required|string',
            'jumlah' => 'required|numeric|min:0',
        ]);

        $project->pembayaran()->create($validatedData);

        return redirect()->route('pelaksana.projects.pembayaran.index', $project->id)
            ->with('success', 'Data pembayaran berhasil dicatat.');
    }

    public function show(Project $project, Pembayaran $pembayaran)
    {
        // Tampilkan detail jika perlu, untuk sekarang kita redirect ke index
        return redirect()->route('pelaksana.projects.pembayaran.index', $project->id);
    }

    public function edit(Project $project, Pembayaran $pembayaran)
    {
        $jenisPekerjaanOptions = $project->jenisPekerjaan()->pluck('nama_pekerjaan', 'id');
        return view('pelaksana.pembayaran.edit', compact('project', 'pembayaran', 'jenisPekerjaanOptions'));
    }

    public function update(Request $request, Project $project, Pembayaran $pembayaran)
    {
        $validatedData = $request->validate([
            'jenis_pekerjaan_id' => 'required|exists:jenis_pekerjaans,id',
            'tanggal_pembayaran' => 'required|date',
            'jenis_transaksi' => 'required|string|max:255',
            'keterangan' => 'required|string',
            'jumlah' => 'required|numeric|min:0',
        ]);

        $pembayaran->update($validatedData);

        return redirect()->route('pelaksana.projects.pembayaran.index', $project->id)
            ->with('success', 'Data pembayaran berhasil diperbarui.');
    }

    public function destroy(Project $project, Pembayaran $pembayaran)
    {
        $pembayaran->delete();
        return redirect()->route('pelaksana.projects.pembayaran.index', $project->id)
            ->with('success', 'Data pembayaran berhasil dihapus.');
    }
}
