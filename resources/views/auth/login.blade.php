{{-- ====================================================================== --}}
{{--   KODE UNTUK FILE: resources/views/auth/login.blade.php             --}}
{{--   Gantikan seluruh isi file login.blade.php Anda dengan kode ini.      --}}
{{-- ====================================================================== --}}

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Login - {{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts & Styles -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Figtree', sans-serif;
        }
    </style>
</head>

<body class="antialiased">
    <div class="flex flex-col sm:flex-row min-h-screen bg-gray-100">
        <!-- Kolom Kiri: Informasi Sistem -->
        <div class="w-full sm:w-1/2 lg:w-2/5 bg-sky-600 text-white flex flex-col justify-center p-8 sm:p-12">
            <div class="max-w-md mx-auto">
                <h1 class="text-3xl font-bold mb-4">
                    Sistem Informasi Manajemen Pelaporan Proyek
                </h1>
                <p class="text-sky-200 leading-relaxed">
                    Selamat datang. Aplikasi ini dirancang untuk mendigitalisasi dan menyederhanakan proses pelaporan
                    proyek, meningkatkan efisiensi, akurasi, dan transparansi data untuk pengambilan keputusan yang
                    lebih baik.
                </p>
            </div>
        </div>

        <!-- Kolom Kanan: Form Login -->
        <div class="w-full sm:w-1/2 lg:w-3/5 flex items-center justify-center p-6 sm:p-8">
            <div class="w-full max-w-md">

                <!-- Logo Aplikasi Anda di sini -->
                <div class="mb-6 flex justify-center">
                    <a href="/">
                        <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
                    </a>
                </div>

                <div class="bg-white rounded-2xl shadow-xl p-8">
                    <!-- Session Status -->
                    <x-auth-session-status class="mb-4" :status="session('status')" />

                    <div class="mb-6 text-center">
                        <h2 class="text-2xl font-bold text-gray-900">Masuk ke Akun Anda</h2>
                        <p class="text-sm text-gray-900">Silakan masukkan email dan password.</p>
                    </div>

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <!-- Email Address -->
                        <div>
                            <x-input-label for="email" value="Email" />
                            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email"
                                :value="old('email')" required autofocus autocomplete="username" />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <!-- Password -->
                        <div class="mt-6">
                            <x-input-label for="password" value="Password" />
                            {{-- Fitur Lihat/Sembunyikan Password --}}
                            <div class="relative">
                                <x-text-input id="password" class="block mt-1 w-full" type="password" name="password"
                                    required autocomplete="current-password" />
                                <button type="button" id="togglePassword"
                                    class="absolute inset-y-0 right-0 px-3 flex items-center text-gray-500">
                                    <svg id="eye-open" class="h-5 w-5" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.022 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                        </path>
                                    </svg>
                                    <svg id="eye-closed" class="h-5 w-5 hidden" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7 1.274-4.057 5.022 7 9.542-7 .847 0 1.668.124 2.458.352M7.5 7.5l12 12M15 12a3 3 0 11-6 0 3 3 0 016 0z">
                                        </path>
                                    </svg>
                                </button>
                            </div>
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>

                        <div class="mt-6">
                            <x-primary-button class="w-full text-center justify-center py-3">
                                {{ __('Masuk') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        const togglePassword = document.getElementById('togglePassword');
        const password = document.getElementById('password');
        const eyeOpen = document.getElementById('eye-open');
        const eyeClosed = document.getElementById('eye-closed');
        togglePassword.addEventListener('click', function() {
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            eyeOpen.classList.toggle('hidden');
            eyeClosed.classList.toggle('hidden');
        });
    </script>
</body>

</html>
