@extends('layouts.admin_app')
@section('title', 'Edit Tenaga Kerja')
@section('header')
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Edit Tenaga Kerja: <span
            class="font-normal">{{ $tenagaKerja->nama_pekerja }}</span></h2>
@endsection
@section('content')
    <form method="POST" action="{{ route('admin.projects.tenaga-kerja.update', [$project->id, $tenagaKerja->id]) }}"
        class="space-y-6 max-w-lg mx-auto bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md">
        @csrf
        @method('PUT')
        <div>
            <label for="nama_pekerja" class="block font-medium text-sm text-gray-700 dark:text-gray-300 mb-1">Nama
                Pekerja</label>
            <input id="nama_pekerja" type="text" name="nama_pekerja"
                value="{{ old('nama_pekerja', $tenagaKerja->nama_pekerja) }}" required class="block w-full rounded-md ...">
        </div>
        <div>
            <label for="posisi"
                class="block font-medium text-sm text-gray-700 dark:text-gray-300 mb-1">Posisi/Jabatan</label>
            <input id="posisi" type="text" name="posisi" value="{{ old('posisi', $tenagaKerja->posisi) }}" required
                class="block w-full ...">
        </div>
        <div>
            <label for="honor_harian" class="block font-medium text-sm text-gray-700 dark:text-gray-300 mb-1">Honor Harian
                (Rp)</label>
            <input id="honor_harian" type="number" name="honor_harian"
                value="{{ old('honor_harian', $tenagaKerja->honor_harian) }}" required class="block w-full ...">
        </div>
        <div>
            <label for="alamat_pekerja" class="block font-medium text-sm text-gray-700 dark:text-gray-300 mb-1">Alamat
                (Opsional)</label>
            <textarea id="alamat_pekerja" name="alamat_pekerja" rows="3" class="block w-full ...">{{ old('alamat_pekerja', $tenagaKerja->alamat_pekerja) }}</textarea>
        </div>
        <div class="flex items-center justify-end pt-6 border-t border-gray-200 dark:border-gray-700">
            <a href="{{ route('admin.projects.tenaga-kerja.index', $project->id) }}" class="px-6 py-2 ...">Batal</a>
            <button type="submit" class="ml-3 ...">Update</button>
        </div>
    </form>
@endsection
