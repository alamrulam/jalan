<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    Detail Proyek
                </h2>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                    {{ $project->nama_proyek }}
                </p>
            </div>
            <a href="{{ route('admin.projects.index') }}"
                class="mt-3 sm:mt-0 inline-flex items-center px-4 py-2 bg-gray-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-600 active:bg-gray-700 focus:outline-none focus:border-gray-700 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                <svg class="w-4 h-4 mr-2 -ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali ke Daftar
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                {{-- Kolom Kiri: Detail Proyek & Modul Baru --}}
                <div class="lg:col-span-2 space-y-6">
                    <!-- Kartu Informasi Proyek -->
                    <div class="bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg">
                        <div
                            class="px-4 py-5 sm:px-6 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
                            <div>
                                <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white">Informasi Proyek
                                </h3>
                            </div>
                            <a href="{{ route('admin.projects.edit', $project->id) }}"
                                class="text-sm font-medium text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300">Edit
                                Proyek</a>
                        </div>
                        <div class="border-t border-gray-200 dark:border-gray-700">
                            <dl>
                                <div
                                    class="bg-gray-50 dark:bg-gray-700/50 px-4 py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Lokasi</dt>
                                    <dd class="mt-1 text-sm text-gray-900 dark:text-white sm:mt-0 sm:col-span-2">
                                        {{ $project->lokasi }}</dd>
                                </div>
                                <div
                                    class="bg-white dark:bg-gray-800 px-4 py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Jenis Proyek</dt>
                                    <dd class="mt-1 text-sm text-gray-900 dark:text-white sm:mt-0 sm:col-span-2">
                                        {{ $project->jenis_proyek }}</dd>
                                </div>
                                <div
                                    class="bg-gray-50 dark:bg-gray-700/50 px-4 py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Periode</dt>
                                    <dd class="mt-1 text-sm text-gray-900 dark:text-white sm:mt-0 sm:col-span-2">
                                        {{ \Carbon\Carbon::parse($project->tanggal_mulai)->isoFormat('D MMM YYYY') }} -
                                        {{ \Carbon\Carbon::parse($project->tanggal_selesai)->isoFormat('D MMM YYYY') }}
                                    </dd>
                                </div>
                            </dl>
                        </div>
                    </div>

                    <!-- Kartu Jenis Pekerjaan -->
                    <div class="bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg">
                        <div
                            class="px-4 py-5 sm:px-6 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
                            <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white">Jenis Pekerjaan &
                                Progres</h3>
                            <a href="{{ route('admin.projects.jenis-pekerjaan.index', $project->id) }}"
                                class="text-sm font-medium text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300">Kelola</a>
                        </div>
                        <div class="p-6">
                            {{-- Daftar Jenis Pekerjaan --}}
                        </div>
                    </div>
                </div>

                {{-- Kolom Kanan: Kartu-kartu Aksi --}}
                <div class="lg:col-span-1 space-y-6">
                    <!-- Kartu Profil Perusahaan -->
                    <div class="bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg">
                        <div class="px-4 py-5 sm:px-6 border-b ... flex justify-between items-center">
                            <h3 class="text-lg ...">Profil Perusahaan</h3>
                            <a href="{{ route('admin.profil.edit', $project->id) }}" class="text-sm ...">Kelola</a>
                        </div>
                        <div class="p-6">
                            {{-- Detail Profil --}}
                        </div>
                    </div>

                    <!-- Kartu Tenaga Kerja -->
                    <div class="bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg">
                        <div class="px-4 py-5 sm:px-6 border-b ... flex justify-between items-center">
                            <h3 class="text-lg ...">Tenaga Kerja</h3>
                            <a href="{{ route('admin.projects.tenaga-kerja.index', $project->id) }}"
                                class="text-sm ...">Kelola</a>
                        </div>
                        <div class="p-6 text-center">
                            <p class="text-5xl font-bold ...">{{ $project->tenagaKerja->count() }}</p>
                            <p class="text-sm ...">Orang Terdaftar</p>
                        </div>
                    </div>

                    <!-- Kartu Pelaksana Ditugaskan -->
                    <div class="bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg">
                        <div class="px-4 py-5 sm:px-6 border-b ... flex justify-between items-center">
                            <h3 class="text-lg ...">Pelaksana Ditugaskan</h3>
                            <a href="{{ route('admin.projects.edit', $project->id) }}" class="text-sm ...">Kelola</a>
                        </div>
                        <div class="p-6">
                            {{-- Daftar Pelaksana --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
