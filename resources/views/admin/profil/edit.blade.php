@extends('layouts.admin_app')
@section('title', 'Edit Profil Perusahaan')
@section('header')
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        Edit Profil Perusahaan untuk Proyek: {{ $project->nama_proyek }}
    </h2>
@endsection
@section('content')
    <form method="POST" action="{{ route('admin.profil.update', $project->id) }}"
        class="space-y-6 max-w-lg mx-auto bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md">
        @csrf
        @method('PUT')
        <div>
            <label for="nama_lembaga" class="block font-medium text-sm text-gray-700 dark:text-gray-300 mb-1">Nama Lembaga
                (BKAD/CV/PT)</label>
            <input id="nama_lembaga" type="text" name="nama_lembaga" value="{{ old('nama_lembaga', $profil->nama_lembaga) }}"
                required class="block w-full ...">
            @error('nama_lembaga')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
        <div>
            <label for="alamat" class="block font-medium text-sm text-gray-700 dark:text-gray-300 mb-1">Alamat</label>
            <textarea id="alamat" name="alamat" rows="3" required class="block w-full ...">{{ old('alamat', $profil->alamat) }}</textarea>
            @error('alamat')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
        <div>
            <label for="nama_ketua" class="block font-medium text-sm text-gray-700 dark:text-gray-300 mb-1">Nama
                Ketua/Penanggung Jawab</label>
            <input id="nama_ketua" type="text" name="nama_ketua" value="{{ old('nama_ketua', $profil->nama_ketua) }}"
                required class="block w-full ...">
            @error('nama_ketua')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
        <div>
            <label for="kontak" class="block font-medium text-sm text-gray-700 dark:text-gray-300 mb-1">Kontak (No.
                HP/Telepon)</label>
            <input id="kontak" type="text" name="kontak" value="{{ old('kontak', $profil->kontak) }}"
                class="block w-full ...">
            @error('kontak')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
        <div class="flex items-center justify-end pt-6 border-t border-gray-200 dark:border-gray-700">
            <a href="{{ route('admin.projects.show', $project->id) }}" class="px-6 py-2 ...">Batal</a>
            <button type="submit" class="ml-3 ...">Simpan Profil</button>
        </div>
    </form>
@endsection
