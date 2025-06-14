<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Detail Proyek
            </h2>
            <a href="{{ route('admin.projects.index') }}"
                class="inline-flex items-center px-4 py-2 bg-gray-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-600 active:bg-gray-700 focus:outline-none focus:border-gray-700 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
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
                {{-- Kolom Kiri: Detail Proyek --}}
                <div class="lg:col-span-2 space-y-6">
                    <div class="bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg">
                        <div class="px-4 py-5 sm:px-6 border-b border-gray-200 dark:border-gray-700">
                            <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white">
                                Informasi Proyek
                            </h3>
                            <p class="mt-1 max-w-2xl text-sm text-gray-500 dark:text-gray-400">
                                {{ $project->nama_proyek }}
                            </p>
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
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Tanggal Mulai</dt>
                                    <dd class="mt-1 text-sm text-gray-900 dark:text-white sm:mt-0 sm:col-span-2">
                                        {{ \Carbon\Carbon::parse($project->tanggal_mulai)->isoFormat('dddd, D MMMM YYYY') }}
                                    </dd>
                                </div>
                                <div
                                    class="bg-white dark:bg-gray-800 px-4 py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Tanggal Selesai
                                    </dt>
                                    <dd class="mt-1 text-sm text-gray-900 dark:text-white sm:mt-0 sm:col-span-2">
                                        {{ \Carbon\Carbon::parse($project->tanggal_selesai)->isoFormat('dddd, D MMMM YYYY') }}
                                    </dd>
                                </div>
                            </dl>
                        </div>
                    </div>
                </div>

                {{-- Kolom Kanan: Pelaksana Ditugaskan --}}
                <div class="lg:col-span-1">
                    <div class="bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg">
                        <div class="px-4 py-5 sm:px-6 border-b border-gray-200 dark:border-gray-700">
                            <div class="flex justify-between items-center">
                                <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white">
                                    Pelaksana Ditugaskan
                                </h3>
                                <a href="{{ route('admin.projects.edit', $project->id) }}"
                                    class="px-3 py-1 border border-indigo-400 rounded-md text-indigo-500 hover:text-indigo-700 hover:bg-indigo-50 dark:hover:bg-gray-700 text-sm font-medium transition-colors duration-150"
                                    title="Kelola Penugasan">
                                    Kelola
                                </a>
                            </div>
                        </div>
                        <div class="p-6">
                            @forelse ($project->assignedUsers as $user)
                                <div class="flex items-center mb-4">
                                    {{-- Ikon profil dihapus --}}
                                    <div>
                                        <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $user->name }}
                                        </p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ $user->email }}</p>
                                    </div>
                                </div>
                            @empty
                                <p class="text-sm text-gray-500 dark:text-gray-400">Belum ada pelaksana yang ditugaskan
                                    ke proyek ini.</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<hr class="border-dashed my-8">
