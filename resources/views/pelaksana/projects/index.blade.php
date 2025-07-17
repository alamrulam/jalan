<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Proyek Saya') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse ($projects as $project)
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-md rounded-lg flex flex-col">
                        <div class="p-6 flex-grow">
                            <h3 class="font-semibold text-lg text-gray-900 dark:text-white mb-2">
                                {{ $project->nama_proyek }}</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">
                                <span class="font-medium">Lokasi:</span> {{ $project->lokasi }}
                            </p>
                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                <span class="font-medium">Jenis:</span> {{ $project->jenis_proyek }}
                            </p>
                            <div class="mt-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                    Periode:
                                    {{ \Carbon\Carbon::parse($project->tanggal_mulai)->isoFormat('D MMM YYYY') }} -
                                    {{ \Carbon\Carbon::parse($project->tanggal_selesai)->isoFormat('D MMM YYYY') }}
                                </p>
                            </div>
                        </div>
                        <div class="px-6 py-4 bg-gray-50 dark:bg-gray-700/50">
                            <div class="flex items-center justify-end">
                                {{-- Tombol ini akan mengarahkan ke halaman daftar pembayaran untuk proyek ini --}}
                                <a href="{{ route('pelaksana.projects.pembayaran.index', $project->id) }}"
                                    class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 active:bg-green-800 focus:outline-none focus:border-green-900 focus:ring ring-green-300 disabled:opacity-25 transition ease-in-out duration-150">
                                    <svg class="w-4 h-4 mr-2 -ml-1" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 8h6m-5 0a3 3 0 110 6H9l-2 2V8a2 2 0 012-2z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 110-6h- kapasitas 2 2 0 00-2 2v8l-2-2h-1a3 3 0 01-3-3V8a3 3 0 013-3h6a3 3 0 013 3v3a3 3 0 01-3 3z">
                                        </path>
                                    </svg>
                                    Kelola Pembayaran
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-1 md:col-span-2 lg:col-span-3">
                        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6 text-center text-gray-900 dark:text-gray-100">
                                Anda belum ditugaskan pada proyek apapun saat ini.
                            </div>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
