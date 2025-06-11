@extends('layouts.admin_app') {{-- Menggunakan layout admin yang sudah ada --}}

@section('title', 'Dashboard Admin')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('Dashboard Admin') }}
    </h2>
@endsection

@section('content')
    {{-- Bagian Kartu Statistik --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
        <!-- Kartu Laporan Pending -->
        <div class="bg-yellow-100 dark:bg-yellow-700/50 p-6 rounded-lg shadow-md flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-yellow-800 dark:text-yellow-200 uppercase">Laporan Pending</p>
                <p class="text-3xl font-bold text-yellow-900 dark:text-yellow-100">{{ $pendingReportsCount }}</p>
            </div>
            <div class="bg-yellow-500 p-3 rounded-full">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http:www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
        </div>
        <!-- Kartu Total Proyek -->
        <div class="bg-blue-100 dark:bg-blue-700/50 p-6 rounded-lg shadow-md flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-blue-800 dark:text-blue-200 uppercase">Total Proyek</p>
                <p class="text-3xl font-bold text-blue-900 dark:text-blue-100">{{ $totalProjectsCount }}</p>
            </div>
            <div class="bg-blue-500 p-3 rounded-full">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http:www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                    </path>
                </svg>
            </div>
        </div>
        <!-- Kartu Total Pelaksana -->
        <div class="bg-green-100 dark:bg-green-700/50 p-6 rounded-lg shadow-md flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-green-800 dark:text-green-200 uppercase">Total Pelaksana</p>
                <p class="text-3xl font-bold text-green-900 dark:text-green-100">{{ $totalPelaksanaCount }}</p>
            </div>
            <div class="bg-green-500 p-3 rounded-full">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http:www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                    </path>
                </svg>
            </div>
        </div>
    </div>

    {{-- Bagian Grafik dan Laporan Terbaru --}}
    <div class="grid grid-cols-1 lg:grid-cols-5 gap-6">
        <!-- Grafik Status Laporan -->
        <div class="lg:col-span-3 bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4">Grafik Status Laporan</h3>
            <div class="chart-container relative h-[300px] w-full max-w-2xl mx-auto">
                <canvas id="reportStatusChart"></canvas>
            </div>
        </div>

        <!-- Laporan Terbaru -->
        <div class="lg:col-span-2 bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4">5 Laporan Harian Terbaru</h3>
            <div class="space-y-4">
                @forelse($recentReports as $report)
                    <a href="{{ route('admin.reports.show', $report->id) }}"
                        class="block p-3 bg-gray-50 dark:bg-gray-700/50 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md transition-colors duration-150">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="font-semibold text-gray-900 dark:text-white">
                                    {{ $report->project->nama_proyek ?? 'N/A' }}</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">Oleh: {{ $report->user->name ?? 'N/A' }}
                                    - {{ \Carbon\Carbon::parse($report->tanggal_laporan)->isoFormat('D MMM YY') }}</p>
                            </div>
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
                    <p class="text-sm text-gray-500 dark:text-gray-400">Belum ada laporan yang masuk.</p>
                @endforelse
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https:cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('reportStatusChart').getContext('2d');
            const reportStatusChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: @json($chartLabels),
                    datasets: [{
                        label: 'Jumlah Laporan',
                        data: @json($chartData),
                        backgroundColor: [
                            'rgba(251, 191, 36, 0.6)', //Yellow (Pending)
                            'rgba(52, 211, 153, 0.6)', //Green (Verified)
                            'rgba(239, 68, 68, 0.6)' //Red (Rejected)
                        ],
                        borderColor: [
                            'rgba(251, 191, 36, 1)',
                            'rgba(52, 211, 153, 1)',
                            'rgba(239, 68, 68, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1 // Hanya tampilkan angka bulat di sumbu Y
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: false // Sembunyikan legenda
                        }
                    }
                }
            });
        });
    </script>
@endpush
