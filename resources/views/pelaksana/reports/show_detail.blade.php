<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Detail Laporan Harian Saya <span class="text-blue-600 dark:text-blue-400">#{{ $report->id }}</span>
            </h2>
            <a href="{{ route('pelaksana.reports.history') }}"
                class="inline-flex items-center px-4 py-2 bg-gray-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-600 active:bg-gray-700 focus:outline-none focus:border-gray-700 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                <svg class="w-4 h-4 mr-2 -ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali ke Riwayat
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="bg-white dark:bg-gray-800 shadow-lg overflow-hidden sm:rounded-lg">
                        <div class="px-4 py-5 sm:px-6 border-b border-gray-200 dark:border-gray-700">
                            <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white">
                                Informasi Umum Laporan
                            </h3>
                            <p class="mt-1 max-w-2xl text-sm text-gray-500 dark:text-gray-400">
                                Proyek: <span class="font-semibold">{{ $report->project->nama_proyek ?? 'N/A' }}</span>
                            </p>
                        </div>
                        <div class="border-t border-gray-200 dark:border-gray-700">
                            <dl>
                                <div
                                    class="bg-gray-50 dark:bg-gray-700/50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">ID Laporan</dt>
                                    <dd class="mt-1 text-sm text-gray-900 dark:text-white sm:mt-0 sm:col-span-2">
                                        #{{ $report->id }}</dd>
                                </div>
                                <div
                                    class="bg-white dark:bg-gray-800 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Tanggal Laporan
                                    </dt>
                                    <dd class="mt-1 text-sm text-gray-900 dark:text-white sm:mt-0 sm:col-span-2">
                                        {{ \Carbon\Carbon::parse($report->tanggal_laporan)->isoFormat('dddd, D MMMM YYYY') }}
                                    </dd>
                                </div>
                                {{-- Pelaksana tidak perlu ditampilkan lagi karena ini laporan miliknya --}}
                                <div
                                    class="bg-gray-50 dark:bg-gray-700/50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Status Laporan</dt>
                                    <dd class="mt-1 text-sm text-gray-900 dark:text-white sm:mt-0 sm:col-span-2">
                                        @if ($report->status_laporan == 'pending')
                                            <span
                                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800 dark:bg-yellow-700 dark:text-yellow-100">Pending</span>
                                        @elseif($report->status_laporan == 'verified')
                                            <span
                                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-700 dark:text-green-100">Terverifikasi</span>
                                        @elseif($report->status_laporan == 'rejected')
                                            <span
                                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800 dark:bg-red-700 dark:text-red-100">Ditolak</span>
                                        @else
                                            <span
                                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800 dark:bg-gray-600 dark:text-gray-200">{{ ucfirst($report->status_laporan) }}</span>
                                        @endif
                                    </dd>
                                </div>
                                @if ($report->status_laporan == 'rejected' && $report->catatan_admin)
                                    <div
                                        class="bg-red-50 dark:bg-red-900/30 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                        <dt class="text-sm font-medium text-red-700 dark:text-red-300">Catatan Admin
                                            (Alasan Penolakan)</dt>
                                        <dd
                                            class="mt-1 text-sm text-red-900 dark:text-red-200 sm:mt-0 sm:col-span-2 whitespace-pre-wrap">
                                            {{ $report->catatan_admin }}</dd>
                                    </div>
                                @endif
                            </dl>
                        </div>
                    </div>

                    <div class="mt-8">
                        <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white mb-4">
                            Detail Item Pekerjaan Dilaporkan
                        </h3>
                        @if ($report->reportItems->count() > 0)
                            <div class="space-y-4">
                                @foreach ($report->reportItems as $item)
                                    <div
                                        class="bg-white dark:bg-gray-800 shadow overflow-hidden sm:rounded-md p-4 border border-gray-200 dark:border-gray-700">
                                        <h4 class="text-md font-semibold text-blue-600 dark:text-blue-400">
                                            {{ $item->jenis_pekerjaan }}</h4>
                                        <dl class="mt-2 grid grid-cols-1 gap-x-4 gap-y-4 sm:grid-cols-3">
                                            @if (!is_null($item->panjang))
                                                <div class="sm:col-span-1">
                                                    <dt class="text-xs font-medium text-gray-500 dark:text-gray-400">
                                                        Panjang</dt>
                                                    <dd class="mt-1 text-sm text-gray-900 dark:text-white">
                                                        {{ number_format($item->panjang, 2, ',', '.') }} m</dd>
                                                </div>
                                            @endif
                                            @if (!is_null($item->lebar))
                                                <div class="sm:col-span-1">
                                                    <dt class="text-xs font-medium text-gray-500 dark:text-gray-400">
                                                        Lebar</dt>
                                                    <dd class="mt-1 text-sm text-gray-900 dark:text-white">
                                                        {{ number_format($item->lebar, 2, ',', '.') }} m</dd>
                                                </div>
                                            @endif
                                            @if (!is_null($item->tinggi_atau_tebal))
                                                <div class="sm:col-span-1">
                                                    <dt class="text-xs font-medium text-gray-500 dark:text-gray-400">
                                                        Tinggi/Tebal</dt>
                                                    <dd class="mt-1 text-sm text-gray-900 dark:text-white">
                                                        {{ number_format($item->tinggi_atau_tebal, 2, ',', '.') }} m
                                                    </dd>
                                                </div>
                                            @endif
                                            <div class="sm:col-span-1">
                                                <dt class="text-xs font-medium text-gray-500 dark:text-gray-400">Volume
                                                    Dihitung</dt>
                                                <dd class="mt-1 text-sm font-semibold text-gray-900 dark:text-white">
                                                    {{ number_format($item->volume_dihitung, 2, ',', '.') }}
                                                    {{ $item->satuan_volume }}</dd>
                                            </div>
                                            @if ($item->catatan_item)
                                                <div class="sm:col-span-3">
                                                    <dt class="text-xs font-medium text-gray-500 dark:text-gray-400">
                                                        Catatan Item</dt>
                                                    <dd
                                                        class="mt-1 text-sm text-gray-700 dark:text-gray-300 whitespace-pre-wrap">
                                                        {{ $item->catatan_item }}</dd>
                                                </div>
                                            @endif
                                        </dl>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-sm text-gray-500 dark:text-gray-400">Tidak ada item pekerjaan untuk laporan
                                ini.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
