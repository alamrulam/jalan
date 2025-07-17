@extends('layouts.admin_app')
@section('title', 'Tambah Tenaga Kerja')
@section('header')
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Tambah Tenaga Kerja untuk Proyek: <span
            class="font-normal">{{ $project->nama_proyek }}</span></h2>
@endsection
@section('content')
    <form method="POST" action="{{ route('admin.projects.tenaga-kerja.store', $project->id) }}"
        class="space-y-6 max-w-lg mx-auto bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md">
        @csrf
        <div>
            <label for="nama_pekerja" class="block font-medium text-sm text-gray-700 dark:text-gray-300 mb-1">Nama
                Pekerja</label>
            <input id="nama_pekerja" type="text" name="nama_pekerja" value="{{ old('nama_pekerja') }}" required
                class="block w-full rounded-md shadow-sm border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
            @error('nama_pekerja')
                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
            @enderror
        </div>
        <div>
            <label for="posisi"
                class="block font-medium text-sm text-gray-700 dark:text-gray-300 mb-1">Posisi/Jabatan</label>
            <input id="posisi" type="text" name="posisi" value="{{ old('posisi') }}" required
                placeholder="Contoh: Tukang, Pekerja, Mandor"
                class="block w-full rounded-md shadow-sm border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
            @error('posisi')
                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
            @enderror
        </div>
        <div>
            <label for="honor_harian" class="block font-medium text-sm text-gray-700 dark:text-gray-300 mb-1">Honor Harian
                (Rp)</label>
            <input id="honor_harian" type="number" name="honor_harian" value="{{ old('honor_harian') }}" required
                placeholder="Contoh: 150000"
                class="block w-full rounded-md shadow-sm border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
            @error('honor_harian')
                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
            @enderror
        </div>
        <div>
            <label for="alamat_pekerja" class="block font-medium text-sm text-gray-700 dark:text-gray-300 mb-1">Alamat
                (Opsional)</label>
            <textarea id="alamat_pekerja" name="alamat_pekerja" rows="3"
                class="block w-full rounded-md shadow-sm border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">{{ old('alamat_pekerja') }}</textarea>
            @error('alamat_pekerja')
                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
            @enderror
        </div>
        <div class="flex items-center justify-end pt-6 border-t border-gray-200 dark:border-gray-700">
            <a href="{{ route('admin.projects.tenaga-kerja.index', $project->id) }}"
                class="px-6 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 dark:bg-gray-600 dark:text-gray-200 dark:border-gray-500 dark:hover:bg-gray-500 transition-colors duration-150">Batal</a>
            <button type="submit"
                class="ml-3 inline-flex items-center px-6 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-sm text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-800 focus:outline-none focus:border-blue-800 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">Simpan</button>
        </div>
    </form>
@endsection

<hr class="my-8 border-dashed"
