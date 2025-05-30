<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DailyReport;
use Illuminate\Http\Request;
use App\Models\Project;
use Barryvdh\DomPDF\Facade\Pdf; // Atau use PDF; jika alias 'PDF' sudah Anda daftarkan di config/app.php
use App\Exports\DailyReportsExport; // Import Export Class Anda
    use Maatwebsite\Excel\Facades\Excel; // Import fasad Excel
class DailyReportController extends Controller
{
    /**
     * Menampilkan daftar semua laporan harian.
     */
    public function index(Request $request)
    {
        // Query dasar untuk mengambil laporan dengan relasi proyek dan user (pelaksana)
        // Diurutkan berdasarkan tanggal laporan terbaru, kemudian ID terbaru
        $query = DailyReport::with(['project', 'user'])->latest('tanggal_laporan')->latest('id');

        // Implementasi Filter (Contoh sederhana)
        if ($request->has('status_laporan') && $request->status_laporan != '') {
            $query->where('status_laporan', $request->status_laporan);
        }

        if ($request->has('project_id') && $request->project_id != '') {
            $query->where('project_id', $request->project_id);
        }

        if ($request->has('tanggal_dari') && $request->tanggal_dari != '') {
            $query->whereDate('tanggal_laporan', '>=', $request->tanggal_dari);
        }

        if ($request->has('tanggal_sampai') && $request->tanggal_sampai != '') {
            $query->whereDate('tanggal_laporan', '<=', $request->tanggal_sampai);
        }

        $reports = $query->paginate(15); // Ambil data dengan paginasi

        // Ambil data semua proyek untuk filter dropdown
        $projects = Project::orderBy('nama_proyek')->get();

        // Kirim variabel $reports dan $projects ke view
        return view('admin.reports.index', compact('reports', 'projects'));
    }

    /**
     * Menampilkan detail laporan harian.
     */
    public function show(DailyReport $report) // Menggunakan Route Model Binding
    {
        // Eager load relasi untuk menghindari N+1 query problem di view
        $report->load(['project', 'user', 'reportItems']);

        return view('admin.reports.show', compact('report'));
    }

    public function verify(DailyReport $report)
    {
        // Pastikan hanya laporan dengan status 'pending' atau 'rejected' yang bisa diverifikasi
        if (!in_array($report->status_laporan, ['pending', 'rejected'])) {
            return redirect()->route('admin.reports.show', $report->id)->with('error', 'Laporan ini tidak bisa diverifikasi karena statusnya bukan pending atau rejected.');
        }

        $report->status_laporan = 'verified';
        $report->catatan_admin = null; // Hapus catatan admin jika sebelumnya ditolak lalu diverifikasi
        $report->save();

        return redirect()->route('admin.reports.show', $report->id)->with('success', 'Laporan berhasil diverifikasi.');
    }

    public function reject(Request $request, DailyReport $report)
    {
        // Pastikan hanya laporan dengan status 'pending' yang bisa ditolak
        // (atau sesuaikan logikanya jika laporan yang sudah terverifikasi bisa ditolak kembali)
        if ($report->status_laporan != 'pending') {
            return redirect()->route('admin.reports.show', $report->id)->with('error', 'Hanya laporan dengan status pending yang bisa ditolak.');
        }

        $request->validate([
            'catatan_admin' => 'required|string|min:10', // Alasan penolakan wajib diisi
        ]);

        $report->status_laporan = 'rejected';
        $report->catatan_admin = $request->catatan_admin;
        $report->save();

        return redirect()->route('admin.reports.show', $report->id)->with('success', 'Laporan berhasil ditolak dengan catatan.');
    }

    /**
     * Mengekspor data laporan harian ke PDF.
     */
    public function exportPdf(Request $request)
    {
        // Logika pengambilan data sama dengan method index(),
        // tapi tanpa paginasi karena kita ingin semua data yang terfilter.
        $query = DailyReport::with(['project', 'user', 'reportItems']) // Eager load reportItems juga
                            ->latest('tanggal_laporan')
                            ->latest('id');

        if ($request->has('status_laporan') && $request->status_laporan != '') {
            $query->where('status_laporan', $request->status_laporan);
        }
        if ($request->has('project_id') && $request->project_id != '') {
            $query->where('project_id', $request->project_id);
        }
        if ($request->has('tanggal_dari') && $request->tanggal_dari != '') {
            $query->whereDate('tanggal_laporan', '>=', $request->tanggal_dari);
        }
        if ($request->has('tanggal_sampai') && $request->tanggal_sampai != '') {
            $query->whereDate('tanggal_laporan', '<=', $request->tanggal_sampai);
        }

        $reports = $query->get(); // Ambil semua data yang sesuai filter, tanpa paginasi

        if ($reports->isEmpty()) {
            return redirect()->back()->with('error', 'Tidak ada data laporan untuk diekspor berdasarkan filter yang dipilih.');
        }

        // Data tambahan untuk view PDF jika perlu (misalnya judul, periode)
        $dataUntukPdf = [
            'reports' => $reports,
            'judulLaporan' => 'Laporan Harian Proyek',
            'periodeFilter' => $this->buatPeriodeFilterText($request), // Memanggil helper function
        ];

        // Load view PDF dengan data
        $pdf = Pdf::loadView('admin.reports.pdf_template', $dataUntukPdf);

        // Atur nama file PDF yang akan di-download
        $namaFile = 'laporan_harian_proyek_' . date('Y-m-d_His') . '.pdf';

        // Download file PDF
        return $pdf->download($namaFile);

        // Atau jika ingin menampilkan di browser dulu (stream):
        // return $pdf->stream($namaFile);
    }

    /**
     * Helper function untuk membuat teks periode filter.
     */
    private function buatPeriodeFilterText(Request $request)
    {
        $texts = [];
        if ($request->filled('project_id')) {
            $project = Project::find($request->project_id);
            if ($project) {
                $texts[] = "Proyek: " . $project->nama_proyek;
            }
        }
        if ($request->filled('status_laporan')) {
            $texts[] = "Status: " . ucfirst($request->status_laporan);
        }
        if ($request->filled('tanggal_dari')) {
            $texts[] = "Dari Tgl: " . \Carbon\Carbon::parse($request->tanggal_dari)->isoFormat('D MMM YY');
        }
        if ($request->filled('tanggal_sampai')) {
            $texts[] = "Sampai Tgl: " . \Carbon\Carbon::parse($request->tanggal_sampai)->isoFormat('D MMM YY');
        }
        return implode(', ', $texts);
    }

     /**
         * Mengekspor data laporan harian ke Excel.
         */
        public function exportExcel(Request $request)
        {
            // Logika pengambilan data sama dengan method exportPdf()
            $query = DailyReport::with(['project', 'user', 'reportItems'])
                                ->latest('tanggal_laporan')
                                ->latest('id');

            if ($request->has('status_laporan') && $request->status_laporan != '') {
                $query->where('status_laporan', $request->status_laporan);
            }
            if ($request->has('project_id') && $request->project_id != '') {
                $query->where('project_id', $request->project_id);
            }
            if ($request->has('tanggal_dari') && $request->tanggal_dari != '') {
                $query->whereDate('tanggal_laporan', '>=', $request->tanggal_dari);
            }
            if ($request->has('tanggal_sampai') && $request->tanggal_sampai != '') {
                $query->whereDate('tanggal_laporan', '<=', $request->tanggal_sampai);
            }

            $reports = $query->get();

            if ($reports->isEmpty()) {
                return redirect()->back()->with('error', 'Tidak ada data laporan untuk diekspor berdasarkan filter yang dipilih.');
            }

            $periodeFilter = $this->buatPeriodeFilterText($request);
            $judulLaporan = 'Laporan Harian Proyek';
            $namaFile = 'laporan_harian_proyek_' . date('Y-m-d_His') . '.xlsx';

            return Excel::download(new DailyReportsExport($reports, $periodeFilter, $judulLaporan), $namaFile);
        }
   

}  // <-- PASTIKAN INI ADALAH KURUNG KURAWAL PENUTUP TERAKHIR UNTUK CLASS