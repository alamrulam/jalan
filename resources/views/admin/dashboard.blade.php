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

        <!-- Kartu Total Pengeluaran -->
        <div class="p-6 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl shadow-md">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Total
                        Pengeluaran</p>
                    <p class="text-3xl font-bold text-gray-900 dark:text-white">Rp
                        {{ number_format($totalPengeluaran, 0, ',', '.') }}</p>
                </div>
                <div class="bg-red-100 dark:bg-red-500/20 p-3 rounded-full">
                    <svg class="w-6 h-6 text-red-500 dark:text-red-400" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H7a3 3 0 00-3 3v8a3 3 0 003 3z">
                        </path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Kartu Total Proyek -->
        <div class="p-6 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl shadow-md">
            <div class="flex items-center justify-between">
                <div>
                    <a href="{{ route('admin.projects.index') }}"
                        class="block text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider hover:text-blue-600 dark:hover:text-blue-400 hover:underline">
                        Total Proyek
                    </a>
                    <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $totalProjectsCount }}</p>
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

        <!-- Kartu Total Pelaksana -->
        <div class="p-6 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl shadow-md">
            <div class="flex items-center justify-between">
                <div>
                    <a href="{{ route('admin.users.index') }}"
                        class="block text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider hover:text-blue-600 dark:hover:text-blue-400 hover:underline">
                        Total Pelaksana
                    </a>
                    <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $totalPelaksanaCount }}</p>
                </div>
                <div class="bg-green-100 dark:bg-green-500/20 p-3 rounded-full">
                    <svg class="w-6 h-6 text-green-500 dark:text-green-400" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                        </path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    {{-- Bagian Grafik dan Pembayaran Terbaru --}}
    <div class="grid grid-cols-1 lg:grid-cols-5 gap-6">
        <!-- Grafik Pengeluaran per Proyek -->
        <div class="lg:col-span-3 bg-white dark:bg-gray-800 p-6 rounded-xl shadow-md">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4">5 Proyek dengan Pengeluaran Terbesar
            </h3>
            <div class="chart-container relative h-[300px] w-full max-w-full mx-auto">
                <canvas id="topProjectsChart"></canvas>
            </div>
        </div>

        <!-- Pembayaran Terbaru -->
        <div class="lg:col-span-2 bg-white dark:bg-gray-800 p-6 rounded-xl shadow-md">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4">5 Transaksi Pembayaran Terbaru</h3>
            <div class="space-y-3">
                @forelse($recentPembayarans as $pembayaran)
                    <div class="p-3 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                        <div class="flex justify-between items-start">
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-semibold text-gray-900 dark:text-white truncate"
                                    title="{{ $pembayaran->keterangan }}">{{ $pembayaran->keterangan }}</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400 truncate">Proyek:
                                    {{ $pembayaran->project->nama_proyek ?? 'N/A' }}</p>
                            </div>
                            <div class="flex-shrink-0 ml-2 text-right">
                                <p class="text-sm font-bold text-red-600 dark:text-red-400">Rp
                                    {{ number_format($pembayaran->jumlah, 0, ',', '.') }}</p>
                                <p class="text-xs text-gray-400">
                                    {{ \Carbon\Carbon::parse($pembayaran->tanggal_pembayaran)->isoFormat('D MMM YY') }}</p>
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-sm text-center text-gray-500 dark:text-gray-400 py-8">Belum ada data pembayaran.</p>
                @endforelse
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('topProjectsChart').getContext('2d');
            const topProjectsChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: @json($chartLabels),
                    datasets: [{
                        label: 'Total Pengeluaran (Rp)',
                        data: @json($chartData),
                        backgroundColor: 'rgba(59, 130, 246, 0.6)',
                        borderColor: 'rgba(59, 130, 246, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    indexAxis: 'y', // Membuat bar menjadi horizontal
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        x: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value, index, values) {
                                    return 'Rp ' + value.toLocaleString('id-ID');
                                }
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: false
                        }
                    }
                }
            });
        });
    </script>
@endpush
