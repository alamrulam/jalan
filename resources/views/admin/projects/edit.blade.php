@extends('layouts.admin_app')

@section('title', 'Edit Proyek')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('Edit Proyek: ') }} <span class="font-bold text-blue-600 dark:text-blue-400">{{ $project->nama_proyek }}</span>
    </h2>
@endsection

@section('content')
    <form method="POST" action="{{ route('admin.projects.update', $project->id) }}" class="space-y-6">
        @csrf
        @method('PUT')

        {{-- Bagian detail proyek --}}
        <div>
            <h3 class="text-lg font-medium text-gray-700 dark:text-gray-600 mb-2">Detail Proyek</h3>
            <div class="p-6 bg-gray-50 dark:bg-gray-900/20 border border-gray-200 dark:border-gray-700 rounded-lg space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="nama_proyek" class="block font-medium text-sm text-gray-700 dark:text-gray-600 mb-1">Nama
                            Proyek</label>
                        <input id="nama_proyek"
                            class="block w-full rounded-md shadow-sm border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-800 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                            type="text" name="nama_proyek" value="{{ old('nama_proyek', $project->nama_proyek) }}"
                            required autofocus />
                        @error('nama_proyek')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="lokasi"
                            class="block font-medium text-sm text-gray-700 dark:text-gray-600 mb-1">Lokasi</label>
                        <input id="lokasi"
                            class="block w-full rounded-md shadow-sm border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-800 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                            type="text" name="lokasi" value="{{ old('lokasi', $project->lokasi) }}" required />
                        @error('lokasi')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div>
                    <label for="tanggal_mulai"
                        class="block font-medium text-sm text-gray-700 dark:text-gray-600 mb-1">Tanggal Mulai</label>
                    <input id="tanggal_mulai"
                        class="block w-full rounded-md shadow-sm border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-800 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                        type="date" name="tanggal_mulai" value="{{ old('tanggal_mulai', $project->tanggal_mulai) }}"
                        required />
                    @error('tanggal_mulai')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="tanggal_selesai"
                        class="block font-medium text-sm text-gray-700 dark:text-gray-600 mb-1">Tanggal Selesai</label>
                    <input id="tanggal_selesai"
                        class="block w-full rounded-md shadow-sm border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-800 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                        type="date" name="tanggal_selesai"
                        value="{{ old('tanggal_selesai', $project->tanggal_selesai) }}" required />
                    @error('tanggal_selesai')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="jenis_proyek" class="block font-medium text-sm text-gray-700 dark:text-gray-600 mb-1">Jenis
                        Proyek</label>
                    <input id="jenis_proyek"
                        class="block w-full rounded-md shadow-sm border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-800 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                        type="text" name="jenis_proyek" value="{{ old('jenis_proyek', $project->jenis_proyek) }}"
                        required />
                    @error('jenis_proyek')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        {{-- Bagian untuk menugaskan pelaksana --}}
        <div>
            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-600 mb-2">Tugaskan Pelaksana</h3>
            <div class="p-6 bg-gray-50 dark:bg-gray-900/20 border border-gray-200 dark:border-gray-700 rounded-lg">
                <label for="pelaksana_ids" class="block font-medium text-sm text-gray-700 dark:text-gray-600 mb-1">Pilih
                    Pelaksana (bisa lebih dari satu):</label>
                <select name="pelaksana_ids[]" id="pelaksana_ids" multiple
                    class="block w-full h-40 rounded-md shadow-sm border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    @foreach ($pelaksanas as $pelaksana)
                        <option value="{{ $pelaksana->id }}"
                            {{ in_array($pelaksana->id, old('pelaksana_ids', $assignedPelaksanaIds ?? [])) ? 'selected' : '' }}>
                            {{ $pelaksana->name }} ({{ $pelaksana->email }})
                        </option>
                    @endforeach
                </select>
                <p class="mt-1 text-xs text-gray-500 dark:text-gray-600">Tahan Ctrl (atau Cmd di Mac) untuk memilih lebih
                    dari satu.</p>
                @error('pelaksana_ids.*')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="flex items-center justify-end mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
            <a href="{{ route('admin.projects.index') }}"
                class="px-6 py-3 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:bg-gray-600 dark:text-gray-200 dark:border-gray-500 dark:hover:bg-gray-500 transition-colors duration-150">
                Batal
            </a>
            <button type="submit"
                class="ml-3 inline-flex items-center px-6 py-3 bg-blue-600 border rounded-md font-semibold text-sm dark:text-gray-200 tracking-widest hover:bg-blue-700 active:bg-blue-800 focus:outline-none focus:border-blue-800 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                Update Proyek
            </button>
        </div>
    </form>
@endsection

<hr class="border-dashed my-8">
