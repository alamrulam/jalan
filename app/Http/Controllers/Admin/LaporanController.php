<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanController extends Controller
{
    // Menampilkan halaman form untuk memilih proyek
    public function index()
    {
        $projects = Project::orderBy('nama_proyek')->get();
        return view('admin.laporan.index', compact('projects'));
    }

    // Memproses dan mengekspor laporan
    public function export(Request $request)
    {
        $request->validate([
            'project_id' => 'required|exists:projects,id',
            'format' => 'required|in:pdf,excel', // Validasi format
        ]);

        $project = Project::with([
            'profilPerusahaan',
            'tenagaKerja',
            'jenisPekerjaan.pembayaran' // Memuat pembayaran untuk setiap jenis pekerjaan
        ])->findOrFail($request->project_id);

        // Menghitung total pengeluaran
        $totalPengeluaran = $project->pembayaran->sum('jumlah');

        $dataUntukLaporan = [
            'project' => $project,
            'totalPengeluaran' => $totalPengeluaran,
            'dicetakOleh' => auth()->user()->name,
        ];

        if ($request->format == 'pdf') {
            $pdf = Pdf::loadView('admin.laporan.template_pdf', $dataUntukLaporan);
            $pdf->setPaper('a4', 'portrait');
            $namaFile = 'laporan_proyek_' . $project->id . '_' . date('Y-m-d') . '.pdf';
            return $pdf->download($namaFile);
        }

        // Logika untuk Excel bisa ditambahkan di sini jika perlu
        // else if ($request->format == 'excel') {
        //     // return Excel::download(new ProjectReportExport($dataUntukLaporan), 'laporan.xlsx');
        // }

        return back()->with('error', 'Format ekspor tidak valid.');
    }
}
