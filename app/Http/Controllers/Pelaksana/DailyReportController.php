<?php

namespace App\Http\Controllers\Pelaksana;

use App\Http\Controllers\Controller;
use App\Models\DailyReport;
use App\Models\Project;
use App\Models\ReportItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; // Untuk transaction
use Illuminate\Validation\Rule;

class DailyReportController extends Controller
{
    // Daftar jenis pekerjaan dan konfigurasi inputnya
    // Ini bisa juga disimpan di config file atau helper
    protected $jenisPekerjaanConfig = [
        'Pembersihan Lokasi' => ['panjang', 'lebar'],
        'Leveling Rataan' => ['panjang', 'lebar', 'tinggi_atau_tebal'],
        'Urugan Sirtu (Begisting)' => ['panjang', 'lebar', 'tinggi_atau_tebal'], // Perlu klarifikasi rumus
        'Alas Plastik' => ['panjang', 'lebar'],
        'Cor Beton' => ['panjang', 'lebar', 'tinggi_atau_tebal'],
        // Tambahkan jenis pekerjaan lainnya di sini
    ];

    /**
     * Menampilkan form untuk membuat laporan harian baru untuk proyek tertentu.
     */
    public function create(Project $project)
    {
        // Pastikan pelaksana ditugaskan ke proyek ini (jika ada sistem penugasan)
        // Untuk saat ini, kita asumsikan akses sudah benar melalui rute
        if (!Auth::user()->assignedProjects()->where('projects.id', $project->id)->exists() && Auth::user()->role == 'pelaksana') {
            // Jika ada tabel pivot project_user, dan ingin ada validasi penugasan
            // return redirect()->route('pelaksana.projects.index')->with('error', 'Anda tidak ditugaskan pada proyek ini.');
        }

        $jenisPekerjaanOptions = array_keys($this->jenisPekerjaanConfig);

        return view('pelaksana.reports.create', compact('project', 'jenisPekerjaanOptions'));
    }

    /**
     * Menyimpan laporan harian baru.
     */
    public function store(Request $request, Project $project)
    {
        // Validasi dasar untuk laporan harian
        $validatedData = $request->validate([
            'tanggal_laporan' => 'required|date|before_or_equal:today',
            'items' => 'required|array|min:1', // Pastikan ada minimal 1 item pekerjaan
            'items.*.jenis_pekerjaan' => ['required', 'string', Rule::in(array_keys($this->jenisPekerjaanConfig))],
            'items.*.panjang' => 'nullable|numeric|min:0',
            'items.*.lebar' => 'nullable|numeric|min:0',
            'items.*.tinggi_atau_tebal' => 'nullable|numeric|min:0',
            'items.*.catatan_item' => 'nullable|string|max:1000',
        ]);

        // Memulai database transaction untuk memastikan konsistensi data
        DB::beginTransaction();
        try {
            $dailyReport = DailyReport::create([
                'project_id' => $project->id,
                'user_id' => Auth::id(),
                'tanggal_laporan' => $validatedData['tanggal_laporan'],
                'status_laporan' => 'pending', // Default status
            ]);

            foreach ($validatedData['items'] as $itemData) {
                $jenisPekerjaan = $itemData['jenis_pekerjaan'];
                $panjang = $itemData['panjang'] ?? null;
                $lebar = $itemData['lebar'] ?? null;
                $tinggi = $itemData['tinggi_atau_tebal'] ?? null;
                $volumeDihitung = 0;
                $satuanVolume = '-';

                // Validasi tambahan dan perhitungan berdasarkan jenis pekerjaan
                $requiredDimensions = $this->jenisPekerjaanConfig[$jenisPekerjaan] ?? [];
                foreach ($requiredDimensions as $dim) {
                    if (!isset($itemData[$dim]) || !is_numeric($itemData[$dim]) || $itemData[$dim] <= 0) {
                        // Rollback dan lempar error jika dimensi yang dibutuhkan tidak valid
                        DB::rollBack();
                        return back()->withErrors(['items' => "Dimensi '{$dim}' wajib diisi dan valid untuk pekerjaan '{$jenisPekerjaan}'."])->withInput();
                    }
                }

                // --- PERHITUNGAN VOLUME DI BACKEND (WAJIB) ---
                if ($jenisPekerjaan == 'Pembersihan Lokasi' || $jenisPekerjaan == 'Alas Plastik') {
                    $volumeDihitung = ($panjang ?? 0) * ($lebar ?? 0);
                    $satuanVolume = 'm²';
                } elseif (in_array($jenisPekerjaan, ['Leveling Rataan', 'Cor Beton'])) {
                    $volumeDihitung = ($panjang ?? 0) * ($lebar ?? 0) * ($tinggi ?? 0);
                    $satuanVolume = 'm³';
                } elseif ($jenisPekerjaan == 'Urugan Sirtu (Begisting)') {
                    // PERLU KLARIFIKASI RUMUS: Asumsi P x L x T (total untuk 2 sisi)
                    // Jika L adalah lebar SATU sisi, dan T tebal, maka bisa jadi:
                    // $volumeDihitung = ($panjang ?? 0) * ($lebar ?? 0) * ($tinggi ?? 0) * 2;
                    // Untuk sekarang, kita samakan dengan Cor Beton, TAPI INI PERLU DIPASTIKAN
                    $volumeDihitung = ($panjang ?? 0) * ($lebar ?? 0) * ($tinggi ?? 0);
                    $satuanVolume = 'm³';
                    // Tambahkan catatan bahwa ini perlu klarifikasi jika perlu
                }
                // Tambahkan kondisi lain jika ada

                ReportItem::create([
                    'daily_report_id' => $dailyReport->id,
                    'jenis_pekerjaan' => $jenisPekerjaan,
                    'panjang' => $panjang,
                    'lebar' => $lebar,
                    'tinggi_atau_tebal' => $tinggi,
                    'volume_dihitung' => $volumeDihitung,
                    'satuan_volume' => $satuanVolume,
                    'catatan_item' => $itemData['catatan_item'] ?? null,
                ]);
            }

            DB::commit(); // Jika semua berhasil, simpan perubahan
            return redirect()->route('pelaksana.projects.index')->with('success', 'Laporan harian berhasil disimpan.');
        } catch (\Exception $e) {
            DB::rollBack(); // Jika ada error, batalkan semua perubahan
            // Log error: Log::error($e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat menyimpan laporan. Silakan coba lagi. Pesan: ' . $e->getMessage())->withInput();
        }
    }

    // Method untuk menampilkan riwayat laporan pelaksana (akan dibuat di bagian lain)
    // public function history() { ... }
    /**
     * Menampilkan riwayat laporan harian milik pelaksana yang sedang login.
     */
    public function history(Request $request)
    {
        $pelaksana = Auth::user();

        // Query dasar untuk mengambil laporan milik pelaksana ini,
        // beserta relasi ke proyek.
        // Diurutkan berdasarkan tanggal laporan terbaru, kemudian ID terbaru.
        $query = DailyReport::where('user_id', $pelaksana->id)
            ->with('project') // Eager load relasi project
            ->latest('tanggal_laporan')
            ->latest('id');

        // Implementasi Filter Sederhana (opsional, bisa dikembangkan)
        if ($request->has('status_laporan_filter') && $request->status_laporan_filter != '') {
            $query->where('status_laporan', $request->status_laporan_filter);
        }
        if ($request->has('project_filter') && $request->project_filter != '') {
            $query->where('project_id', $request->project_filter);
        }
        if ($request->has('tanggal_filter') && $request->tanggal_filter != '') {
            $query->whereDate('tanggal_laporan', $request->tanggal_filter);
        }

        $reports = $query->paginate(15);

        // Ambil daftar proyek yang pernah dilaporkan oleh pelaksana ini untuk filter
        $reportedProjects = Project::whereHas('dailyReports', function ($q) use ($pelaksana) {
            $q->where('user_id', $pelaksana->id);
        })->orderBy('nama_proyek')->get();

        return view('pelaksana.reports.history', compact('reports', 'reportedProjects'));
    }

    /**
     * Menampilkan detail laporan harian dari sisi pelaksana.
     */
    public function showReportDetail(DailyReport $report) // Menggunakan Route Model Binding
    {
        // Pastikan laporan ini milik pelaksana yang sedang login
        if ($report->user_id !== Auth::id()) {
            // abort(403, 'Akses tidak diizinkan.'); // Alternatif jika ingin halaman error standar
            return redirect()->route('pelaksana.reports.history')->with('error', 'Anda tidak memiliki izin untuk melihat detail laporan ini.');
        }
        $report->load(['project', 'reportItems']); // Eager load relasi

        return view('pelaksana.reports.show_detail', compact('report'));
    }
}
