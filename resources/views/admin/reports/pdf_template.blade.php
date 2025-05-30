 <!DOCTYPE html>
 <html lang="id">

 <head>
     <meta charset="UTF-8">
     <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
     <title>{{ $judulLaporan ?? 'Laporan Harian Proyek' }}</title>
     <style>
         body {
             font-family: 'DejaVu Sans', sans-serif;
             margin: 0;
             font-size: 10px;
         }

         .container {
             padding: 20px;
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
             margin: 5px 0;
             font-size: 10px;
         }

         table {
             width: 100%;
             border-collapse: collapse;
             margin-bottom: 20px;
         }

         th,
         td {
             border: 1px solid #666;
             padding: 6px;
             text-align: left;
         }

         th {
             background-color: #f2f2f2;
             font-weight: bold;
             font-size: 10px;
         }

         .report-item-table {
             margin-top: 5px;
             margin-bottom: 10px;
             width: 95%;
             margin-left: 2.5%;
         }

         .report-item-table th,
         .report-item-table td {
             border: 1px solid #ccc;
             padding: 4px;
             font-size: 9px;
         }

         .report-item-table th {
             background-color: #e9e9e9;
         }

         .page-break {
             page-break-after: always;
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

         .filter-info {
             font-size: 9px;
             margin-bottom: 15px;
             color: #333;
         }
     </style>
 </head>

 <body>
     <div class="header">
         <h1>{{ $judulLaporan ?? 'Laporan Harian Proyek' }}</h1>
         @if (isset($periodeFilter) && !empty($periodeFilter))
             <p>Periode/Filter: {{ $periodeFilter }}</p>
         @endif
         <p>Tanggal Cetak: {{ \Carbon\Carbon::now()->isoFormat('D MMMM YYYY, HH:mm') }}</p>
     </div>

     <div class="container">
         @if ($reports->isEmpty())
             <p>Tidak ada data laporan untuk ditampilkan.</p>
         @else
             <table>
                 <thead>
                     <tr>
                         <th>ID</th>
                         <th>Proyek</th>
                         <th>Pelaksana</th>
                         <th>Tgl Laporan</th>
                         <th>Status</th>
                     </tr>
                 </thead>
                 <tbody>
                     @foreach ($reports as $report)
                         <tr>
                             <td>#{{ $report->id }}</td>
                             <td>{{ $report->project->nama_proyek ?? 'N/A' }}</td>
                             <td>{{ $report->user->name ?? 'N/A' }}</td>
                             <td>{{ \Carbon\Carbon::parse($report->tanggal_laporan)->isoFormat('D MMM YY') }}</td>
                             <td>{{ ucfirst($report->status_laporan) }}</td>
                         </tr>
                         @if ($report->reportItems->count() > 0)
                             <tr>
                                 <td colspan="5" style="padding:0;">
                                     <table class="report-item-table">
                                         <thead>
                                             <tr>
                                                 <th>Jenis Pekerjaan</th>
                                                 <th>P (m)</th>
                                                 <th>L (m)</th>
                                                 <th>T/T (m)</th>
                                                 <th>Volume</th>
                                                 <th>Satuan</th>
                                                 <th>Catatan</th>
                                             </tr>
                                         </thead>
                                         <tbody>
                                             @foreach ($report->reportItems as $item)
                                                 <tr>
                                                     <td>{{ $item->jenis_pekerjaan }}</td>
                                                     <td>{{ !is_null($item->panjang) ? number_format($item->panjang, 2, ',', '.') : '-' }}
                                                     </td>
                                                     <td>{{ !is_null($item->lebar) ? number_format($item->lebar, 2, ',', '.') : '-' }}
                                                     </td>
                                                     <td>{{ !is_null($item->tinggi_atau_tebal) ? number_format($item->tinggi_atau_tebal, 2, ',', '.') : '-' }}
                                                     </td>
                                                     <td>{{ number_format($item->volume_dihitung, 2, ',', '.') }}</td>
                                                     <td>{{ $item->satuan_volume }}</td>
                                                     <td>{{ $item->catatan_item ?? '-' }}</td>
                                                 </tr>
                                             @endforeach
                                         </tbody>
                                     </table>
                                 </td>
                             </tr>
                         @endif
                     @endforeach
                 </tbody>
             </table>
         @endif
     </div>

     <div class="footer">
         <span class="page-number"></span>
     </div>
 </body>

 </html>

