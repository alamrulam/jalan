<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan Proyek - {{ $project->nama_proyek }}</title>
    <style>
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 10px;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header h1 {
            margin: 0;
            font-size: 18px;
        }

        .header p {
            margin: 0;
            font-size: 12px;
        }

        .info-table,
        .main-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .info-table td {
            padding: 5px;
        }

        .main-table th,
        .main-table td {
            border: 1px solid #333;
            padding: 6px;
            text-align: left;
        }

        .main-table th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        .text-right {
            text-align: right;
        }

        .total-row {
            font-weight: bold;
            background-color: #f2f2f2;
        }

        h3 {
            font-size: 14px;
            margin-top: 25px;
            margin-bottom: 10px;
            border-bottom: 1px solid #ccc;
            padding-bottom: 5px;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>Laporan Akhir Proyek</h1>
        <p>{{ $project->profilPerusahaan->nama_lembaga ?? 'Nama Lembaga Belum Diisi' }}</p>
    </div>

    <h3>A. Informasi Umum Proyek</h3>
    <table class="info-table">
        <tr>
            <td style="width: 30%;"><strong>Nama Proyek</strong></td>
            <td>: {{ $project->nama_proyek }}</td>
        </tr>
        <tr>
            <td><strong>Lokasi</strong></td>
            <td>: {{ $project->lokasi }}</td>
        </tr>
        <tr>
            <td><strong>Jenis Proyek</strong></td>
            <td>: {{ $project->jenis_proyek }}</td>
        </tr>
        <tr>
            <td><strong>Periode</strong></td>
            <td>: {{ \Carbon\Carbon::parse($project->tanggal_mulai)->isoFormat('D MMM YYYY') }} s.d.
                {{ \Carbon\Carbon::parse($project->tanggal_selesai)->isoFormat('D MMM YYYY') }}</td>
        </tr>
    </table>

    <h3>B. Rincian Jenis Pekerjaan & Progres</h3>
    <table class="main-table">
        <thead>
            <tr>
                <th>Nama Pekerjaan</th>
                <th>Deskripsi</th>
                <th class="text-right">Progres</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($project->jenisPekerjaan as $jp)
                <tr>
                    <td>{{ $jp->nama_pekerjaan }}</td>
                    <td>{{ $jp->deskripsi ?? '-' }}</td>
                    <td class="text-right">{{ $jp->progres }}%</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h3>C. Rincian Pengeluaran / Pembayaran</h3>
    <table class="main-table">
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Kelompok Pekerjaan</th>
                <th>Jenis Transaksi</th>
                <th>Keterangan</th>
                <th class="text-right">Jumlah (Rp)</th>
            </tr>
        </thead>
        <tbody>
            @forelse($project->pembayaran as $p)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($p->tanggal_pembayaran)->isoFormat('D MMM YY') }}</td>
                    <td>{{ $p->jenisPekerjaan->nama_pekerjaan ?? 'N/A' }}</td>
                    <td>{{ $p->jenis_transaksi }}</td>
                    <td>{{ $p->keterangan }}</td>
                    <td class="text-right">{{ number_format($p->jumlah, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="text-align:center;">Belum ada data pembayaran.</td>
                </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr class="total-row">
                <td colspan="4" class="text-right">TOTAL PENGELUARAN</td>
                <td class="text-right">{{ number_format($totalPengeluaran, 0, ',', '.') }}</td>
            </tr>
        </tfoot>
    </table>

    <h3>D. Daftar Tenaga Kerja</h3>
    <table class="main-table">
        <thead>
            <tr>
                <th>Nama Pekerja</th>
                <th>Posisi</th>
                <th>Alamat</th>
                <th class="text-right">Honor Harian (Rp)</th>
            </tr>
        </thead>
        <tbody>
            @forelse($project->tenagaKerja as $tk)
                <tr>
                    <td>{{ $tk->nama_pekerja }}</td>
                    <td>{{ $tk->posisi }}</td>
                    <td>{{ $tk->alamat_pekerja ?? '-' }}</td>
                    <td class="text-right">{{ number_format($tk->honor_harian, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" style="text-align:center;">Belum ada data tenaga kerja.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div style="margin-top: 40px; font-size: 9px;">
        Dicetak oleh: {{ $dicetakOleh }} pada {{ \Carbon\Carbon::now()->isoFormat('D MMMM YYYY, HH:mm') }}
    </div>
</body>

</html>
