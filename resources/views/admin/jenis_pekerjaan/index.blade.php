@extends('layouts.admin_app')
@section('title', 'Manajemen Jenis Pekerjaan')
@section('header')
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        Manajemen Jenis Pekerjaan: <span class="text-blue-600">{{ $project->nama_proyek }}</span>
    </h2>
@endsection

@section('content')
    <div class="mb-6 flex justify-between items-center">
        <a href="{{ route('admin.projects.jenis-pekerjaan.create', $project->id) }}"
            class="inline-flex items-center px-4 py-2 bg-blue-600 ...">
            Tambah Jenis Pekerjaan
        </a>
        <a href="{{ route('admin.projects.show', $project->id) }}" class="text-sm ...">&larr; Kembali ke Detail Proyek</a>
    </div>
    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-md sm:rounded-lg">
        <div class="overflow-x-auto">
            <table class="min-w-full ...">
                <thead class="bg-gray-50 dark:bg-gray-700/50">
                    <tr>
                        <th ...>Nama Pekerjaan</th>
                        <th ...>Deskripsi</th>
                        <th ...>Progres</th>
                        <th ...>Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 ...">
                    @forelse ($jenisPekerjaan as $jp)
                        <tr class="hover:bg-sky-100 ...">
                            <td ...>{{ $jp->nama_pekerjaan }}</td>
                            <td ...>{{ $jp->deskripsi ?? '-' }}</td>
                            <td ...>
                                <div class="w-full bg-gray-200 rounded-full dark:bg-gray-700">
                                    <div class="bg-blue-600 text-xs font-medium text-blue-100 text-center p-0.5 leading-none rounded-full"
                                        style="width: {{ $jp->progres }}%"> {{ $jp->progres }}%</div>
                                </div>
                            </td>
                            <td ... class="text-center">
                                <div class="flex items-center justify-center space-x-4">
                                    <a href="{{ route('admin.projects.jenis-pekerjaan.edit', [$project->id, $jp->id]) }}"
                                        title="Edit">...</a>
                                    <form
                                        action="{{ route('admin.projects.jenis-pekerjaan.destroy', [$project->id, $jp->id]) }}"
                                        method="POST" onsubmit="...">
                                        @csrf @method('DELETE')
                                        <button type="submit" title="Hapus">...</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center p-6 ...">Belum ada data jenis pekerjaan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="mt-6">{{ $jenisPekerjaan->links() }}</div>
@endsection
