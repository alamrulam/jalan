{{-- ====================================================================== --}}
{{--   KODE UNTUK FILE: resources/views/welcome.blade.php                 --}}
{{--   Gantikan seluruh isi file welcome.blade.php Anda dengan kode ini.    --}}
{{-- ====================================================================== --}}

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sistem Pelaporan Proyek</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts & Styles -->
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        body {
            font-family: 'Figtree', sans-serif;
            scroll-behavior: smooth;
        }
    </style>
</head>

<body class="antialiased text-gray-700 bg-gray-50">
    <div class="relative min-h-screen">
        <!-- Header Navigasi -->
        <header class="absolute top-0 left-0 right-0 z-10 bg-transparent">
            <nav class="container mx-auto px-6 py-4 flex justify-between items-center">
                <div class="text-xl font-bold text-gray-800 flex items-center space-x-3">
                    {{-- LOGO ITG DIUBAH MENJADI LOKAL --}}
                    <img src="{{ asset('img/logo-itg.png') }}" alt="Logo ITG" class="h-10 w-auto">
                    <a href="/">Pelaporan Proyek</a>
                </div>
                <div>
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}"
                                class="font-semibold text-gray-600 hover:text-gray-900 focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}"
                                class="font-semibold text-gray-600 hover:text-gray-900 focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Masuk</a>

                            {{-- Ingat, kita sudah menonaktifkan rute register. Jika ingin mengaktifkan lagi, hilangkan komentar di bawah. --}}
                            {{-- @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="ml-4 font-semibold text-gray-600 hover:text-gray-900 focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Daftar</a>
                                @endif --}}
                        @endauth
                    @endif
                </div>
            </nav>
        </header>

        <!-- Hero Section -->
        <main class="relative isolate pt-14">
            <div class="absolute inset-x-0 -top-40 -z-10 transform-gpu overflow-hidden blur-3xl sm:-top-80"
                aria-hidden="true">
                <div class="relative left-[calc(50%-11rem)] aspect-[1155/678] w-[36.125rem] -translate-x-1/2 rotate-[30deg] bg-gradient-to-tr from-[#80d4ff] to-[#3b82f6] opacity-30 sm:left-[calc(50%-30rem)] sm:w-[72.1875rem]"
                    style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)">
                </div>
            </div>

            <div class="py-24 sm:py-32">
                <div class="mx-auto max-w-2xl text-center px-4">
                    <h1 class="text-4xl font-bold tracking-tight text-gray-900 sm:text-6xl">Manajemen Pelaporan Proyek
                        Menjadi Lebih Mudah</h1>
                    <p class="mt-6 text-lg leading-8 text-gray-600">Digitalisasi proses pelaporan proyek konstruksi
                        Anda. Tingkatkan efisiensi, kurangi kesalahan, dan pantau progres secara real-time dari mana
                        saja.</p>
                    <div class="mt-10 flex items-center justify-center gap-x-6">
                        <a href="{{ route('login') }}"
                            class="rounded-md bg-sky-600 px-6 py-3 text-sm font-semibold text-white shadow-sm hover:bg-sky-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-sky-600">Mulai
                            Sekarang</a>
                    </div>
                </div>
            </div>

            <div class="absolute inset-x-0 top-[calc(100%-13rem)] -z-10 transform-gpu overflow-hidden blur-3xl sm:top-[calc(100%-30rem)]"
                aria-hidden="true">
                <div class="relative left-[calc(50%+3rem)] aspect-[1155/678] w-[36.125rem] -translate-x-1/2 bg-gradient-to-tr from-[#3b82f6] to-[#93c5fd] opacity-30 sm:left-[calc(50%+36rem)] sm:w-[72.1875rem]"
                    style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)">
                </div>
            </div>
        </main>

        <!-- Fitur Utama Section -->
        <section class="py-16 bg-white">
            <div class="container mx-auto px-6">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-bold text-gray-900">Fitur Utama</h2>
                    <p class="text-gray-600 mt-2">Solusi lengkap untuk manajemen pelaporan proyek yang modern.</p>
                </div>
                <div class="grid md:grid-cols-3 gap-8 text-center">
                    <div class="p-6">
                        <div
                            class="flex items-center justify-center h-12 w-12 rounded-md bg-sky-600 text-white mx-auto mb-4">
                            <!-- Ikon untuk Pelaporan Real-time -->
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900">Pelaporan Real-time</h3>
                        <p class="mt-2 text-gray-600">Pelaksana lapangan dapat menginput laporan harian langsung dari
                            lokasi proyek.</p>
                    </div>
                    <div class="p-6">
                        <div
                            class="flex items-center justify-center h-12 w-12 rounded-md bg-sky-600 text-white mx-auto mb-4">
                            <!-- Ikon untuk Verifikasi Digital -->
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900">Verifikasi Digital</h3>
                        <p class="mt-2 text-gray-600">Admin dapat memverifikasi atau menolak laporan dengan mudah,
                            lengkap dengan catatan revisi.</p>
                    </div>
                    <div class="p-6">
                        <div
                            class="flex items-center justify-center h-12 w-12 rounded-md bg-sky-600 text-white mx-auto mb-4">
                            <!-- Ikon untuk Ekspor Data -->
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900">Ekspor Data Fleksibel</h3>
                        <p class="mt-2 text-gray-600">Unduh data laporan dalam format PDF untuk arsip atau Excel untuk
                            analisis data lebih lanjut.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Footer Section -->
       <footer class="bg-gray-800 text-gray-400">
                 <div class="container mx-auto px-6 py-8">
                    <div class="sm:flex sm:justify-between text-center sm:text-left">
                        <div class="mb-4 sm:mb-0">
                            <p class="text-sm">&copy; {{ date('Y') }} Sistem Pelaporan Proyek.</p>
                            <p class="text-xs mt-1">Dikembangkan oleh Alam Ruslam untuk Skripsi.</p>
                        </div>
                        <div class="text-sm">
                            <h4 class="font-semibold text-white mb-2">Kontak Kami</h4>
                            <p>WhatsApp: <a href="https://wa.me/6281959755372" class="hover:text-white" target="_blank">+62 819-5975-5372</a></p>
                            <p>Email: <a href="mailto:2106139@itg.ac.id" class="hover:text-white">2106139@itg.ac.id</a></p>
                            <p>Institut Teknologi Garut</p>
                        </div>
                    </div>
                </div>
            </footer>
    </div>
</body>

</html>
