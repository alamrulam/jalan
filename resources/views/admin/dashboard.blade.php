@extends('layouts.admin_app')

@section('title', 'Dashboard Admin')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('Dashboard') }}
    </h2>
@endsection

@section('content')
    {{-- Bagian Kartu Statistik Interaktif --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">

        <!-- Kartu Laporan Pending -->
        <div class="p-6 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl shadow-md">
            <div class="flex items-center justify-between">
                <div>
                    <a href="{{ route('admin.reports.index', ['status_laporan' => 'pending']) }}"
                        class="block text-sm font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider hover:underline">
                        Laporan Pending
                    </a>
                    <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $pendingReportsCount }}</p>
                </div>
                <div class="bg-yellow-100 dark:bg-yellow-500/20 p-3 rounded-full">
                    <svg class="w-6 h-6 text-yellow-500 dark:text-yellow-400" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24" xmlns="http:www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Kartu Total Proyek -->
        <div class="p-6 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl shadow-md">
            <div class="flex items-center justify-between">
                <div>
                    <a href="{{ route('admin.projects.index') }}"
                        class="block text-sm font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider hover:underline">
                        Total Proyek
                    </a>
                    <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $totalProjectsCount }}</p>
                </div>
                <div class="bg-blue-100 dark:bg-blue-500/20 p-3 rounded-full">
                    <svg class="w-6 h-6 text-blue-500 dark:text-blue-400" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24" xmlns="http:www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                        </path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Kartu Total Pelaksana -->
        <div class="p-6 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl shadow-md">
            <div class="flex items-center justify-between">
                <div>
                    <a href="{{ route('admin.users.index') }}"
                        class="block text-sm font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider hover:underline">
                        Total Pelaksana
                    </a>
                    <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $totalPelaksanaCount }}</p>
                </div>
                <div class="bg-green-100 dark:bg-green-500/20 p-3 rounded-full">
                    <svg class="w-6 h-6 text-green-500 dark:text-green-400" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24" xmlns="http:www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                        </path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    {{-- Bagian Grafik dan Laporan Terbaru --}}
    <div class="grid grid-cols-1 lg:grid-cols-5 gap-6">
        <!-- Grafik Status Laporan -->
        <div class="lg:col-span-3 bg-white dark:bg-gray-800 p-6 rounded-xl shadow-md">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4">Distribusi Status Laporan</h3>
            <div class="chart-container relative h-[300px] w-full max-w-sm mx-auto">
                <canvas id="reportStatusChart"></canvas>
            </div>
        </div>

        <!-- Laporan Terbaru -->
        <div class="lg:col-span-2 bg-white dark:bg-gray-800 p-6 rounded-xl shadow-md">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Aktivitas Laporan Terbaru</h3>
                <a href="{{ route('admin.reports.index') }}"
                    class="text-sm font-medium text-blue-600 dark:text-blue-400 hover:underline">Lihat Semua</a>
            </div>
            <div class="space-y-4">
                @forelse($recentReports as $report)
                    <a href="{{ route('admin.reports.show', $report->id) }}"
                        class="flex items-center space-x-4 p-3 hover:bg-gray-50 dark:hover:bg-gray-700/50 rounded-lg transition-colors duration-150">
                        <div class="flex-shrink-0">
                            @if ($report->status_laporan == 'pending')
                                <div class="p-2 bg-yellow-100 dark:bg-yellow-500/20 rounded-full"><svg
                                        class="w-5 h-5 text-yellow-500 dark:text-yellow-400" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24" xmlns="http:www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                        </path>
                                    </svg></div>
                            @elseif($report->status_laporan == 'verified')
                                <div class="p-2 bg-green-100 dark:bg-green-500/20 rounded-full"><svg
                                        class="w-5 h-5 text-green-500 dark:text-green-400" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24" xmlns="http:www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg></div>
                            @else
                                <div class="p-2 bg-red-100 dark:bg-red-500/20 rounded-full"><svg
                                        class="w-5 h-5 text-red-500 dark:text-red-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24" xmlns="http:www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636">
                                        </path>
                                    </svg></div>
                            @endif
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-semibold text-gray-900 dark:text-white truncate">
                                {{ $report->project->nama_proyek ?? 'N/A' }}</p>
                            <p class="text-sm text-gray-500 dark:text-gray-400 truncate">Laporan dari
                                {{ $report->user->name ?? 'N/A' }}
                                ({{ \Carbon\Carbon::parse($report->tanggal_laporan)->isoFormat('D MMM YY') }})</p>
                        </div>
                    </a>
                @empty
                    <p class="text-sm text-center text-gray-500 dark:text-gray-400 py-8">Belum ada laporan yang masuk.</p>
                @endforelse
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('reportStatusChart').getContext('2d');
            const reportStatusChart = new Chart(ctx, {
                type: 'doughnut', // Mengubah tipe chart menjadi doughnut
                data: {
                    labels: @json($chartLabels),
                    datasets: [{
                        label: 'Jumlah Laporan',
                        data: @json($chartData),
                        backgroundColor: [
                            'rgba(251, 191, 36, 0.8)', // Yellow (Pending)
                            'rgba(16, 185, 129, 0.8)', // Green (Verified)
                            'rgba(239, 68, 68, 0.8)' // Red (Rejected)
                        ],
                        borderColor: [
                            'rgba(251, 191, 36, 1)',
                            'rgba(16, 185, 129, 1)',
                            'rgba(239, 68, 68, 1)'
                        ],
                        borderWidth: 1,
                        hoverOffset: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom', //Posisi legenda di bawah
                            labels: {
                                color: document.documentElement.classList.contains('dark') ? '#E5E7EB' :
                                    '#FFFFFF', // Warna teks legenda
                                font: {
                                    size: 12
                                }
                            }
                        }
                    }
                }
            });
        });
    </script>
@endpush

