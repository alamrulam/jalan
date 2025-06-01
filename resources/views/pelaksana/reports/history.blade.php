<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Riwayat Laporan Harian Saya') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{-- ... (kode session message dan filter) ... --}}
                    <div class="mb-6 p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg border dark:border-gray-600">
                        <form method="GET" action="{{ route('pelaksana.reports.history') }}">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <label for="project_filter"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Filter
                                        Proyek</label>
                                    <select name="project_filter" id="project_filter"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-600 dark:border-gray-500 dark:text-white">
                                        <option value="">Semua Proyek Dilaporkan</option>
                                        @foreach ($reportedProjects as $project)
                                            <option value="{{ $project->id }}"
                                                {{ request('project_filter') == $project->id ? 'selected' : '' }}>
                                                {{ $project->nama_proyek }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label for="status_laporan_filter"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Filter
                                        Status</label>
                                    <select name="status_laporan_filter" id="status_laporan_filter"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-600 dark:border-gray-500 dark:text-white">
                                        <option value="">Semua Status</option>
                                        <option value="pending"
                                            {{ request('status_laporan_filter') == 'pending' ? 'selected' : '' }}>
                                            Pending</option>
                                        <option value="verified"
                                            {{ request('status_laporan_filter') == 'verified' ? 'selected' : '' }}>
                                            Terverifikasi</option>
                                        <option value="rejected"
                                            {{ request('status_laporan_filter') == 'rejected' ? 'selected' : '' }}>
                                            Ditolak</option>
                                    </select>
                                </div>
                                <div>
                                    <label for="tanggal_filter"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Filter
                                        Tanggal Laporan</label>
                                    <input type="date" name="tanggal_filter" id="tanggal_filter"
                                        value="{{ request('tanggal_filter') }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-600 dark:border-gray-500 dark:text-white">
                                </div>
                            </div>
                            <div class="mt-4 text-right">
                                <a href="{{ route('pelaksana.reports.history') }}"
                                    class="text-sm text-gray-600 dark:text-gray-400 hover:underline mr-2">Reset
                                    Filter</a>
                                <button type="submit"
                                    class="px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-800 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                                    Cari
                                </button>
                            </div>
                        </form>
                    </div>

                    @if ($reports->count() > 0)
                        <div
                            class="overflow-x-auto bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-700">
                                    <tr>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            ID</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Proyek</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Tgl Laporan</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Status</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Catatan Admin</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                    @foreach ($reports as $report)
                                        <tr
                                            class="hover:bg-sky-100 dark:hover:bg-sky-700/50 transition-colors duration-150">
                                            <td
                                                class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">
                                                #{{ $report->id }}</td>
                                            <td
                                                class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                                {{ $report->project->nama_proyek ?? 'N/A' }}</td>
                                            <td
                                                class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                                {{ \Carbon\Carbon::parse($report->tanggal_laporan)->isoFormat('D MMM YYYY') }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm">/ {{-- ... (kode status laporan) ... --}}
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
                                            </td>
                                            <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-300 whitespace-pre-wrap max-w-xs truncate"
                                                title="{{ $report->catatan_admin }}">
                                                {{ $report->catatan_admin ?? '-' }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <a href="{{ route('pelaksana.reports.showDetail', $report->id) }}"
                                                    class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 inline-flex items-center"
                                                    title="Lihat Detail Laporan">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1"
                                                        viewBox="0 0 20 20" fill="currentColor">
                                                        <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                                        <path fill-rule="evenodd"
                                                            d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.022 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z"
                                                            clip-rule="evenodd" />
                                                    </svg>
                                                    Detail
                                                </a>
                                                @if ($report->status_laporan == 'rejected')
                                                    <a href="{{ route('pelaksana.reports.editRevision', $report->id) }}"
                                                        class="text-yellow-600 hover:text-yellow-800 dark:text-yellow-400 dark:hover:text-yellow-300 inline-flex items-center"
                                                        title="Revisi Laporan Ditolak">
                                                        <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z">
                                                            </path>
                                                        </svg>
                                                        Revisi
                                                    </a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-4">
                            {{ $reports->appends(request()->query())->links() }}
                        </div>
                    @else
                        <p class="text-gray-600 dark:text-gray-400">Anda belum membuat laporan harian apapun.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
