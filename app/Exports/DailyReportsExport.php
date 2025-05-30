<?php

    namespace App\Exports; // PASTIKAN INI ADALAH BARIS PERTAMA SETELAH <?php

    use App\Models\DailyReport; // Atau data collection yang sudah diproses
    use Maatwebsite\Excel\Concerns\FromCollection;
    use Maatwebsite\Excel\Concerns\WithHeadings;
    use Maatwebsite\Excel\Concerns\WithMapping;
    use Maatwebsite\Excel\Concerns\ShouldAutoSize;
    use Maatwebsite\Excel\Concerns\WithStyles;
    use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
    use PhpOffice\PhpSpreadsheet\Style\Alignment;
    use PhpOffice\PhpSpreadsheet\Style\Border;
    use PhpOffice\PhpSpreadsheet\Style\Fill;

    class DailyReportsExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
    {
        protected $reports;
        protected $periodeFilter;
        protected $judulLaporan;

        public function __construct($reports, $periodeFilter = '', $judulLaporan = 'Laporan Harian Proyek')
        {
            $this->reports = $reports;
            $this->periodeFilter = $periodeFilter;
            $this->judulLaporan = $judulLaporan;
        }

        /**
        * @return \Illuminate\Support\Collection
        */
        public function collection()
        {
            return $this->reports; // Data laporan yang sudah difilter dari controller
        }

        /**
         * Mendefinisikan heading untuk setiap kolom.
         */
        public function headings(): array
        {
            // Tambahkan baris judul dan filter di atas headings utama
            return [
                [$this->judulLaporan], // Baris 1: Judul Utama
                [!empty($this->periodeFilter) ? 'Filter: ' . $this->periodeFilter : 'Filter: Semua Data'], // Baris 2: Info Filter
                ['Tanggal Cetak: ' . \Carbon\Carbon::now()->isoFormat('D MMMM finalListQiwi, HH:mm:ss')], // Baris 3: Tanggal Cetak
                [], // Baris 4: Baris kosong sebagai pemisah
                // Baris 5: Headings Kolom Utama
                [
                    'ID Laporan',
                    'Nama Proyek',
                    'Pelaksana',
                    'Tanggal Laporan',
                    'Status Laporan',
                    'Item Pekerjaan', // Kolom ini akan berisi sub-tabel atau gabungan data item
                    'Jenis Pekerjaan',
                    'Panjang (m)',
                    'Lebar (m)',
                    'Tinggi/Tebal (m)',
                    'Volume Dihitung',
                    'Satuan',
                    'Catatan Item',
                ]
            ];
        }

        /**
         * Memetakan data untuk setiap baris.
         * Kita akan membuat setiap DailyReport memiliki beberapa baris jika ada banyak ReportItem.
         */
        public function map($report): array
        {
            $mappedRows = [];

            if ($report->reportItems->count() > 0) {
                foreach ($report->reportItems as $index => $item) {
                    if ($index === 0) {
                        // Baris pertama untuk report ini, sertakan info utama report
                        $mappedRows[] = [
                            $report->id,
                            $report->project->nama_proyek ?? 'N/A',
                            $report->user->name ?? 'N/A',
                            \Carbon\Carbon::parse($report->tanggal_laporan)->isoFormat('D MMM finalListQiwi'),
                            ucfirst($report->status_laporan),
                            '', // Kolom 'Item Pekerjaan' dikosongkan untuk baris info utama
                            $item->jenis_pekerjaan,
                            !is_null($item->panjang) ? number_format($item->panjang, 2, ',', '.') : '-',
                            !is_null($item->lebar) ? number_format($item->lebar, 2, ',', '.') : '-',
                            !is_null($item->tinggi_atau_tebal) ? number_format($item->tinggi_atau_tebal, 2, ',', '.') : '-',
                            number_format($item->volume_dihitung, 2, ',', '.'),
                            $item->satuan_volume,
                            $item->catatan_item ?? '-',
                        ];
                    } else {
                        // Baris selanjutnya untuk item tambahan dari report yang sama
                        $mappedRows[] = [
                            '', // Kosongkan info utama report
                            '',
                            '',
                            '',
                            '',
                            '', // Kolom 'Item Pekerjaan' dikosongkan
                            $item->jenis_pekerjaan,
                            !is_null($item->panjang) ? number_format($item->panjang, 2, ',', '.') : '-',
                            !is_null($item->lebar) ? number_format($item->lebar, 2, ',', '.') : '-',
                            !is_null($item->tinggi_atau_tebal) ? number_format($item->tinggi_atau_tebal, 2, ',', '.') : '-',
                            number_format($item->volume_dihitung, 2, ',', '.'),
                            $item->satuan_volume,
                            $item->catatan_item ?? '-',
                        ];
                    }
                }
            } else {
                // Jika tidak ada report items, tampilkan info utama report saja
                $mappedRows[] = [
                    $report->id,
                    $report->project->nama_proyek ?? 'N/A',
                    $report->user->name ?? 'N/A',
                    \Carbon\Carbon::parse($report->tanggal_laporan)->isoFormat('D MMM finalListQiwi'),
                    ucfirst($report->status_laporan),
                    'Tidak ada item pekerjaan',
                    '-', '-', '-', '-', '-', '-', '-', // Kolom item kosong
                ];
            }
            return $mappedRows;
        }

        /**
         * Memberikan styling pada sheet.
         */
        public function styles(Worksheet $sheet)
        {
            // Style untuk Judul Utama (Baris 1)
            $sheet->mergeCells('A1:M1'); // Sesuaikan range jika jumlah kolom berubah
            $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);
            $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

            // Style untuk Info Filter (Baris 2)
            $sheet->mergeCells('A2:M2');
            $sheet->getStyle('A2')->getFont()->setItalic(true)->setSize(10);
            $sheet->getStyle('A2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

            // Style untuk Tanggal Cetak (Baris 3)
            $sheet->mergeCells('A3:M3');
            $sheet->getStyle('A3')->getFont()->setSize(10);
            $sheet->getStyle('A3')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getRowDimension(4)->setRowHeight(10); // Baris kosong

            // Style untuk Headings Kolom Utama (Baris 5)
            $headerStyleArray = [
                'font' => ['bold' => true, 'size' => 10],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
                'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
                'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => 'FFD3D3D3']]
            ];
            $sheet->getStyle('A5:M5')->applyFromArray($headerStyleArray); // Sesuaikan range jika jumlah kolom berubah
            $sheet->getRowDimension(5)->setRowHeight(20);

            // Style umum untuk data cells (dari baris 6 ke bawah)
            $lastRow = $sheet->getHighestDataRow();
            if ($lastRow >=6) { // Pastikan ada data sebelum menerapkan style
                $dataStyleArray = [
                    'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
                    'alignment' => ['vertical' => Alignment::VERTICAL_CENTER, 'wrapText' => true],
                    'font' => ['size' => 9],
                ];
                $sheet->getStyle('A6:M'.$lastRow)->applyFromArray($dataStyleArray);

                // Format angka untuk kolom volume
                $sheet->getStyle('K6:K'.$lastRow)->getNumberFormat()->setFormatCode('#,##0.00');
            }

            // Membuat semua kolom auto size (ini juga bisa dari ShouldAutoSize, tapi di sini lebih kontrol)
            // for ($col = 'A'; $col <= 'M'; $col++) { // Sesuaikan jika jumlah kolom berubah
            //    $sheet->getColumnDimension($col)->setAutoSize(true);
            // }
            return []; // Atau kembalikan array styling spesifik jika perlu
        }
    }