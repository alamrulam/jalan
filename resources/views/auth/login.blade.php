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
                        <div class="mt-4">
                            <x-input-label for="password" value="Password" />
                            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password"
                                required autocomplete="current-password" />
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>

                        <!-- Remember Me & Forgot Password -->
                        <div class="flex items-center justify-between mt-4">
                            <label for="remember_me" class="inline-flex items-center">
                                <input id="remember_me" type="checkbox"
                                    class="rounded border-gray-300 text-sky-600 shadow-sm focus:ring-sky-500"
                                    name="remember">
                                <span class="ml-2 text-sm text-gray-600">{{ __('Ingat saya') }}</span>
                            </label>

                            @if (Route::has('password.request'))
                                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                    href="{{ route('password.request') }}">
                                    {{ __('Lupa password?') }}
                                </a>
                            @endif
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
</body>

</html>
