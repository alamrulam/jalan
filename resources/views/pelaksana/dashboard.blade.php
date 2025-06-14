 <x-app-layout>
     <x-slot name="header">
         <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
             {{ __('Dashboard Pelaksana') }}
         </h2>
     </x-slot>

     <div class="py-12">
         <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
             {{-- Salam Sambutan --}}
             <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                 <div class="p-6 text-gray-900 dark:text-gray-100">
                     <h3 class="text-lg font-medium">Selamat Datang Kembali, {{ Auth::user()->name }}!</h3>
                     <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Berikut adalah ringkasan aktivitas dan
                         tugas Anda.</p>
                 </div>
             </div>

             {{-- Kartu Statistik --}}
             <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
                 <!-- Kartu Proyek Aktif -->
                 <div
                     class="p-6 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl shadow-md">
                     <div class="flex items-center justify-between">
                         <div>
                             <p class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                 Proyek Ditugaskan</p>
                             <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $assignedProjectsCount }}
                             </p>
                         </div>
                         <div class="bg-blue-100 dark:bg-blue-500/20 p-3 rounded-full">
                             <svg class="w-6 h-6 text-blue-500 dark:text-blue-400" fill="none" stroke="currentColor"
                                 viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                     d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                 </path>
                             </svg>
                         </div>
                     </div>
                 </div>

                 <!-- Kartu Laporan Ditolak -->
                 <div
                     class="p-6 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl shadow-md">
                     <div class="flex items-center justify-between">
                         <div>
                             <p class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                 Perlu Revisi</p>
                             <p class="text-3xl font-bold text-red-600 dark:text-red-400">{{ $rejectedReportsCount }}
                             </p>
                         </div>
                         <div class="bg-red-100 dark:bg-red-500/20 p-3 rounded-full">
                             <svg class="w-6 h-6 text-red-500 dark:text-red-400" fill="none" stroke="currentColor"
                                 viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                     d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                                 </path>
                             </svg>
                         </div>
                     </div>
                 </div>

                 <!-- Kartu Laporan Pending -->
                 <div
                     class="p-6 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl shadow-md">
                     <div class="flex items-center justify-between">
                         <div>
                             <p class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                 Menunggu Persetujuan</p>
                             <p class="text-3xl font-bold text-yellow-600 dark:text-yellow-400">
                                 {{ $pendingReportsCount }}</p>
                         </div>
                         <div class="bg-yellow-100 dark:bg-yellow-500/20 p-3 rounded-full">
                             <svg class="w-6 h-6 text-yellow-500 dark:text-yellow-400" fill="none"
                                 stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                     d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                             </svg>
                         </div>
                     </div>
                 </div>
             </div>

             {{-- Bagian Akses Cepat dan Aktivitas Terbaru --}}
             <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                 <!-- Akses Cepat -->
                 <div class="lg:col-span-1 bg-white dark:bg-gray-800 p-6 rounded-xl shadow-md">
                     <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4">Akses Cepat</h3>
                     <div class="space-y-3">
                         <a href="{{ route('pelaksana.projects.index') }}"
                             class="flex items-center p-3 text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700/50 hover:bg-gray-200 dark:hover:bg-gray-700 rounded-md transition-colors duration-150">
                             <svg class="w-5 h-5 mr-3 text-blue-500" fill="none" stroke="currentColor"
                                 viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                     d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                 </path>
                             </svg>
                             <span>Lihat Proyek Saya</span>
                         </a>
                         <a href="{{ route('pelaksana.reports.history') }}"
                             class="flex items-center p-3 text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700/50 hover:bg-gray-200 dark:hover:bg-gray-700 rounded-md transition-colors duration-150">
                             <svg class="w-5 h-5 mr-3 text-purple-500" fill="none" stroke="currentColor"
                                 viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                     d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                 </path>
                             </svg>
                             <span>Lihat Riwayat Laporan</span>
                         </a>
                     </div>
                 </div>

                 <!-- Aktivitas Laporan Terbaru -->
                 <div class="lg:col-span-2 bg-white dark:bg-gray-800 p-6 rounded-xl shadow-md">
                     <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4">5 Laporan Terakhir Anda
                     </h3>
                     <div class="space-y-4">
                         @forelse($recentReports as $report)
                             <a href="{{ route('pelaksana.reports.showDetail', $report->id) }}"
                                 class="flex items-center space-x-4 p-3 hover:bg-gray-50 dark:hover:bg-gray-700/50 rounded-lg transition-colors duration-150">
                                 <div class="flex-1 min-w-0">
                                     <p class="text-sm font-semibold text-gray-900 dark:text-white truncate">
                                         {{ $report->project->nama_proyek ?? 'N/A' }}</p>
                                     <p class="text-sm text-gray-500 dark:text-gray-400 truncate">Tanggal Laporan:
                                         {{ \Carbon\Carbon::parse($report->tanggal_laporan)->isoFormat('D MMM YYYY') }}
                                     </p>
                                 </div>
                                 <div class="flex-shrink-0">
                                     @if ($report->status_laporan == 'pending')
                                         <span
                                             class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Pending</span>
                                     @elseif($report->status_laporan == 'verified')
                                         <span
                                             class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Terverifikasi</span>
                                     @else
                                         <span
                                             class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Ditolak</span>
                                     @endif
                                 </div>
                             </a>
                         @empty
                             <p class="text-sm text-center text-gray-500 dark:text-gray-400 py-8">Belum ada aktivitas
                                 laporan.</p>
                         @endforelse
                     </div>
                 </div>
             </div>

         </div>
     </div>
 </x-app-layout>
