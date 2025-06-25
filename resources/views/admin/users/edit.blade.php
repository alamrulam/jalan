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
        {{-- Password Confirmation Input with Toggle --}}
        <div>
            <label for="password" class="block font-medium text-sm text-gray-700 dark:text-gray-300 mb-1">Password
                Baru</label>
            <div class="relative">
                <input id="password" type="password" name="password"
                    class="block w-full rounded-md shadow-sm border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 pr-10">
                <button type="button" data-toggle-password="password"
                    class="absolute inset-y-0 right-0 px-3 flex items-center text-gray-500">
                    <svg class="h-5 w-5 eye-open" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.022 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                        </path>
                    </svg>
                    <svg class="h-5 w-5 eye-closed hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7 1.274-4.057 5.022 7 9.542-7 .847 0 1.668.124 2.458.352M7.5 7.5l12 12M15 12a3 3 0 11-6 0 3 3 0 016 0z">
                        </path>
                    </svg>
                </button>
            </div>
            @error('password')
                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
            @enderror
        </div>
        {{-- Password Confirmation Input with Toggle --}}
        <div>
            <label for="password_confirmation"
                class="block font-medium text-sm text-gray-700 dark:text-gray-300 mb-1">Konfirmasi Password Baru</label>
            <div class="relative">
                <input id="password_confirmation" type="password" name="password_confirmation"
                    class="block w-full rounded-md shadow-sm border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 pr-10">
                <button type="button" data-toggle-password="password_confirmation"
                    class="absolute inset-y-0 right-0 px-3 flex items-center text-gray-500">
                    <svg class="h-5 w-5 eye-open" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.022 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                        </path>
                    </svg>
                    <svg class="h-5 w-5 eye-closed hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7 1.274-4.057 5.022 7 9.542-7 .847 0 1.668.124 2.458.352M7.5 7.5l12 12M15 12a3 3 0 11-6 0 3 3 0 016 0z">
                        </path>
                    </svg>
                </button>
            </div>
        </div>
        </div>
        <div class="flex items-center justify-end pt-6 border-t border-gray-200 dark:border-gray-700">
            <a href="{{ route('admin.users.index') }}"
                class="px-6 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:bg-gray-600 dark:text-gray-200 dark:border-gray-500 dark:hover:bg-gray-500 transition-colors duration-150">Batal</a>
            <button type="submit"
                class="ml-3 inline-flex items-center px-6 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-sm text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-800 focus:outline-none focus:border-blue-800 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">Simpan
                Pengguna</button>
        </div>
    </form>
@endsection

@push('scripts')
    <script>
        document.querySelectorAll('[data-toggle-password]').forEach(button => {
            button.addEventListener('click', function() {
                const targetId = this.dataset.togglePassword;
                const passwordInput = document.getElementById(targetId);
                const eyeOpen = this.querySelector('.eye-open');
                const eyeClosed = this.querySelector('.eye-closed');

                if (passwordInput.type === 'password') {
                    passwordInput.type = 'text';
                    eyeOpen.classList.add('hidden');
                    eyeClosed.classList.remove('hidden');
                } else {
                    passwordInput.type = 'password';
                    eyeOpen.classList.remove('hidden');
                    eyeClosed.classList.add('hidden');
                }
            });
        });
    </script>
@endpush
