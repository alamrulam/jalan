@props(['active'])

@php
// Kondisi ini mengatur kelas CSS berdasarkan apakah link sedang aktif atau tidak.
$classes = ($active ?? false)
            // Kelas untuk link aktif: border bawah putih, teks putih tebal.
            ? 'inline-flex items-center px-1 pt-1 border-b-2 border-white text-sm font-semibold leading-5 text-white focus:outline-none focus:border-sky-300 transition duration-150 ease-in-out'
            // Kelas untuk link tidak aktif: border transparan, teks putih-kebiruan.
            : 'inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-sky-100 hover:text-white hover:border-sky-300 focus:outline-none focus:text-white focus:border-sky-300 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>