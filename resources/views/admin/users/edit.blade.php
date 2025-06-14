@extends('layouts.admin_app')
@section('title', 'Edit Pelaksana')
@section('header') <h2 class="font-semibold ...">{{ __('Edit Pelaksana: ') . $user->name }}</h2> @endsection
@section('content')
    <form method="POST" action="{{ route('admin.users.update', $user->id) }}"
        class="space-y-6 max-w-lg mx-auto bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md">
        @csrf
        @method('PUT')
        <div>
            <label for="name" class="block font-medium text-sm text-gray-700 dark:text-gray-300 mb-1">Nama Lengkap</label>
            <input id="name" type="text" name="name" value="{{ old('name', $user->name) }}" required autofocus
                class="block w-full rounded-md shadow-sm border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
            @error('name')
                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
            @enderror
        </div>
        <div>
            <label for="email" class="block font-medium text-sm text-gray-700 dark:text-gray-300 mb-1">Alamat
                Email</label>
            <input id="email" type="email" name="email" value="{{ old('email', $user->email) }}" required
                class="block w-full rounded-md shadow-sm border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
            @error('email')
                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
            @enderror
        </div>
        <div class="border-t border-gray-200 dark:border-gray-700 pt-6 mt-6">
            <p class="text-sm text-gray-500 dark:text-gray-400">Kosongkan bagian password jika tidak ingin mengubahnya.</p>
        </div>
        <div>
            <label for="password" class="block font-medium text-sm text-gray-700 dark:text-gray-300 mb-1">Password
                Baru</label>
            <input id="password" type="password" name="password"
                class="block w-full rounded-md shadow-sm border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
            @error('password')
                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
            @enderror
        </div>
        <div>
            <label for="password_confirmation"
                class="block font-medium text-sm text-gray-700 dark:text-gray-300 mb-1">Konfirmasi Password Baru</label>
            <input id="password_confirmation" type="password" name="password_confirmation"
                class="block w-full rounded-md shadow-sm border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
        </div>
        <div class="flex items-center justify-end pt-6 border-t border-gray-200 dark:border-gray-700">
            <a href="{{ route('admin.users.index') }}"
                class="px-6 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:bg-gray-600 dark:text-gray-200 dark:border-gray-500 dark:hover:bg-gray-500 transition-colors duration-150">Batal</a>
            <button type="submit"
                class="ml-3 inline-flex items-center px-6 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-sm text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-800 focus:outline-none focus:border-blue-800 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">Update
                Pengguna</button>
        </div>
    </form>
@endsection
