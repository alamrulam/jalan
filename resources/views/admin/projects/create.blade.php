@extends('layouts.admin_app')

@section('title', 'Tambah Proyek Baru')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Tambah Proyek Baru') }}
    </h2>
@endsection

@section('content')
    <form method="POST" action="{{ route('admin.projects.store') }}" class="space-y-6">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="nama_proyek" class="block font-medium text-sm text-gray-700 mb-1">Nama Proyek</label>
                <input id="nama_proyek"
                    class="block w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                    type="text" name="nama_proyek" value="{{ old('nama_proyek') }}" required autofocus />
                @error('nama_proyek')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="lokasi" class="block font-medium text-sm text-gray-700 mb-1">Lokasi</label>
                <input id="lokasi"
                    class="block w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                    type="text" name="lokasi" value="{{ old('lokasi') }}" required />
                @error('lokasi')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div>
            <label for="tanggal_mulai" class="block font-medium text-sm text-gray-700 mb-1">Tanggal Mulai</label>
            <input id="tanggal_mulai"
                class="block w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                type="date" name="tanggal_mulai" value="{{ old('tanggal_mulai') }}" required />
            @error('tanggal_mulai')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="tanggal_selesai" class="block font-medium text-sm text-gray-700 mb-1">Tanggal Selesai</label>
            <input id="tanggal_selesai"
                class="block w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                type="date" name="tanggal_selesai" value="{{ old('tanggal_selesai') }}" required />
            @error('tanggal_selesai')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="jenis_proyek" class="block font-medium text-sm text-gray-700 mb-1">Jenis Proyek</label>
            <input id="jenis_proyek"
                class="block w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                type="text" name="jenis_proyek" value="{{ old('jenis_proyek') }}" required />
            @error('jenis_proyek')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center justify-end mt-6 pt-6 border-t border-gray-200">
            <a href="{{ route('admin.projects.index') }}"
                class="px-6 py-3 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-150">
                Batal
            </a>
            <button type="submit"
                class="ml-3 inline-flex items-center px-6 py-3 bg-blue-600 border border-gray-300 rounded-md font-semibold text-sm text-gray-300 hover:bg-blue-700 active:bg-blue-800 focus:outline-none focus:border-blue-800 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                Simpan Proyek
            </button>
        </div>
    </form>
@endsection
