<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>{{ $judulLaporan ?? 'Laporan Harian Proyek' }}</title>
    <style>
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            margin: 0;
            font-size: 9px;
            color: #333;
        }

        .page-break {
            page-break-after: always;
        }

        .header-table {
            width: 100%;
            border-bottom: 1px solid #000;
            margin-bottom: 15px;
        }

        .header-table td {
            padding: 5px;
            vertical-align: top;
        }

        .header-table .logo {
            width: 60px;
            text-align: center;
            font-weight: bold;
        }

        .header-table .title-section {
            text-align: center;
        }

        .title-section h1 {
            margin: 0;
            font-size: 16px;
        }

        .title-section p {
            margin: 0;
            font-size: 10px;
        }

        .info-table {
            width: 100%;
            margin-bottom: 15px;
            font-size: 9px;
        }

        .info-table td {
            padding: 2px 5px;
        }

        .main-table {
            width: 100%;
            border-collapse: collapse;
        }

        .main-table th,
        .main-table td {
            border: 1px solid #666;
            padding: 5px;
            text-align: left;
        }

        .main-table th {
            background-color: #e9e9e9;
            font-weight: bold;
            text-align: center;
        }

        .main-table .item-row td {
            background-color: #f8f8f8;
        }

        .main-table .item-details {
            padding-left: 20px !important;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .footer {
            position: fixed;
            bottom: -30px;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 8px;
        }

        .footer .page-number:before {
            content: "Halaman " counter(page);
        }
    </style>
</head>

<body>
    <header>
        <table class="header-table">
            <tr>
                <td class="logo">[LOGO APLIKASI]</td>
                <td class="title-section">
                    <h1>{{ $judulLaporan ?? 'Laporan Harian Proyek' }}</h1>
                    <p>PT. Sinergi Inovasi Konstruksi (Contoh)</p>
                    <p>Jl. Pembangunan No. 123, Garut, Jawa Barat</p>
                </td>
                <td style="width: 60px;"></td>
            </tr>
        </table>
    </header>

    <main>
        <table class="info-table">
            <tr>
                <td style="width: 15%;"><strong>Filter Aktif:</strong></td>
                <td>{{ !empty($periodeFilter) ? $periodeFilter : 'Semua Data' }}</td>
            </tr>
            <tr>
                <td><strong>Dicetak Oleh:</strong></td>
                <td>{{ $dicetakOleh ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td><strong>Tanggal Cetak:</strong></td>
                <td>{{ \Carbon\Carbon::now()->isoFormat('dddd, D MMMM finalListQiwi, HH:mm:ss') }}</td>
            </tr>
        </table>

        @if ($reports->isEmpty())
            <p>Tidak ada data laporan untuk ditampilkan.</p>
        @else
            <table class="main-table">
                <thead>
                    <tr>
                        <th style="width: 5%;">ID</th>
                        <th style="width: 15%;">Proyek</th>
                        <th style="width: 15%;">Pelaksana</th>
                        <th style="width: 10%;">Tgl Laporan</th>
                        <th style="width: 25%;">Jenis Pekerjaan & Detail</th>
                        <th style="width: 10%;">Volume</th>
                        <th style="width: 20%;">Catatan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($reports as $report)
                        <tr style="background-color: #f0f8ff;">
                            <td class="text-center"><strong>#{{ $report->id }}</strong></td>
                            <td><strong>{{ $report->project->nama_proyek ?? 'N/A' }}</strong></td>
                            <td><strong>{{ $report->user->name ?? 'N/A' }}</strong></td>
                            <td class="text-center">
                                <strong>{{ \Carbon\Carbon::parse($report->tanggal_laporan)->isoFormat('D MMM YY') }}</strong>
                            </td>
                            <td colspan="3">Status: <strong>{{ ucfirst($report->status_laporan) }}</strong>
                                @if ($report->status_laporan == 'rejected' && $report->catatan_admin)
                                    <br><small>Catatan Admin: {{ $report->catatan_admin }}</small>
                                @endif
                            </td>
                        </tr>
                        @if ($report->reportItems->count() > 0)
                            @foreach ($report->reportItems as $item)
                                <tr class="item-row">
                                    <td></td>
                                    <td colspan="3"></td>
                                    <td class="item-details">
                                        <strong>{{ $item->jenis_pekerjaan }}</strong><br>
                                        <small>
                                            @if (!is_null($item->panjang))
                                                P: {{ $item->panjang }}m;
                                            @endif
                                            @if (!is_null($item->lebar))
                                                L: {{ $item->lebar }}m;
                                            @endif
                                            @if (!is_null($item->tinggi_atau_tebal))
                                                T/T: {{ $item->tinggi_atau_tebal }}m;
                                            @endif
                                        </small>
                                    </td>
                                    <td class="text-right">
                                        <strong>{{ number_format($item->volume_dihitung, 2, ',', '.') }}
                                            {{ $item->satuan_volume }}</strong></td>
                                    <td><small>{{ $item->catatan_item ?? '-' }}</small></td>
                                </tr>
                            @endforeach
                        @else
                            <tr class="item-row">
                                <td></td>
                                <td colspan="6" style="padding-left: 20px;"><em>Tidak ada detail item pekerjaan untuk
                                        laporan ini.</em></td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        @endif
    </main>

    <div class="footer">
        <span class="page-number"></span>
    </div>
</body>

</html>
