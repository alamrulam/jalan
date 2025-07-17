@extends('layouts.admin_app')
@section('title', 'Buat Laporan Proyek')
@section('header')
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        Buat Laporan Proyek
    </h2>
@endsection

@section('content')
    <div class="max-w-xl mx-auto bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md">
        <form method="POST" action="{{ route('admin.laporan.export') }}">
            @csrf
            <div class="space-y-6">
                <div>
                    <label for="project_id" class="block font-medium text-sm text-gray-700 dark:text-gray-300 mb-1">Pilih
                        Proyek</label>
                    <select id="project_id" name="project_id" required class="block w-full ...">
                        <option value="">-- Pilih Proyek --</option>
                        @foreach ($projects as $project)
                            <option value="{{ $project->id }}">{{ $project->nama_proyek }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="format" class="block font-medium text-sm text-gray-700 dark:text-gray-300 mb-1">Pilih
                        Format Laporan</label>
                    <select id="format" name="format" required class="block w-full ...">
                        <option value="pdf">PDF</option>
                        <option value="excel" disabled>Excel (Segera Hadir)</option>
                    </select>
                </div>
            </div>
            <div class="flex items-center justify-end mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
                <button type="submit" class="inline-flex items-center px-6 py-2 bg-green-600 ...">
                    <svg class="w-5 h-5 mr-2 -ml-1" ...></svg>
                    Buat & Unduh Laporan
                </button>
            </div>
        </form>
    </div>
@endsection
