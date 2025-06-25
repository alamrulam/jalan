@extends('layouts.admin_app')

@section('title', 'Tambah Proyek Baru')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('Tambah Proyek Baru') }}
    </h2>
@endsection

@section('content')
    <form method="POST" action="{{ route('admin.projects.store') }}" class="space-y-6 max-w-4xl mx-auto">
        @csrf
        <div class="p-6 bg-white dark:bg-gray-800 rounded-lg shadow-md space-y-6">
            {{-- Baris 1: Nama Proyek & Jenis Proyek --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="nama_proyek" class="block font-medium text-sm text-gray-700 dark:text-gray-300 mb-1">Nama
                        Proyek</label>
                    <input id="nama_proyek" type="text" name="nama_proyek" value="{{ old('nama_proyek') }}" required
                        autofocus
                        class="block w-full rounded-md shadow-sm border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    @error('nama_proyek')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="jenis_proyek" class="block font-medium text-sm text-gray-700 dark:text-gray-300 mb-1">Jenis
                        Proyek</label>
                    <select id="jenis_proyek" name="jenis_proyek" required
                        class="block w-full rounded-md shadow-sm border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        <option value="">-- Pilih Jenis Proyek --</option>
                        <option value="Pembangunan Jalan Baru" @if (old('jenis_proyek') == 'Pembangunan Jalan Baru') selected @endif>Pembangunan
                            Jalan Baru</option>
                        <option value="Perbaikan Jalan" @if (old('jenis_proyek') == 'Perbaikan Jalan') selected @endif>Perbaikan Jalan
                        </option>
                        <option value="Pelebaran Jalan Desa" @if (old('jenis_proyek') == 'Pelebaran Jalan Desa') selected @endif>Pelebaran
                            Jalan Desa</option>
                        <option value="Pengaspalan Ulang" @if (old('jenis_proyek') == 'Pengaspalan Ulang') selected @endif>Pengaspalan
                            Ulang</option>
                        <option value="Pengecoran Jalan" @if (old('jenis_proyek') == 'Pengecoran Jalan') selected @endif>Pengecoran Jalan
                        </option>
                    </select>
                    @error('jenis_proyek')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Baris 2: Lokasi (Kecamatan & Desa) --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="kecamatan"
                        class="block font-medium text-sm text-gray-700 dark:text-gray-300 mb-1">Kecamatan</label>
                    <select id="kecamatan" name="kecamatan" required
                        class="block w-full rounded-md shadow-sm border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        <option value="">-- Pilih Kecamatan --</option>
                    </select>
                    @error('kecamatan')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="desa"
                        class="block font-medium text-sm text-gray-700 dark:text-gray-300 mb-1">Desa/Kelurahan</label>
                    <select id="desa" name="desa" required disabled
                        class="block w-full rounded-md shadow-sm border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 disabled:bg-gray-200 dark:disabled:bg-gray-700/50">
                        <option value="">-- Pilih Kecamatan Terlebih Dahulu --</option>
                    </select>
                    @error('desa')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Baris 3: Tanggal Mulai & Selesai --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="tanggal_mulai"
                        class="block font-medium text-sm text-gray-700 dark:text-gray-300 mb-1">Tanggal Mulai</label>
                    <input id="tanggal_mulai" type="date" name="tanggal_mulai" value="{{ old('tanggal_mulai') }}"
                        required
                        class="block w-full rounded-md shadow-sm border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    @error('tanggal_mulai')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="tanggal_selesai"
                        class="block font-medium text-sm text-gray-700 dark:text-gray-300 mb-1">Tanggal Selesai</label>
                    <input id="tanggal_selesai" type="date" name="tanggal_selesai" value="{{ old('tanggal_selesai') }}"
                        required
                        class="block w-full rounded-md shadow-sm border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    @error('tanggal_selesai')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <div class="flex items-center justify-end pt-4">
            <a href="{{ route('admin.projects.index') }}"
                class="px-6 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 dark:bg-gray-600 dark:text-gray-200 dark:border-gray-500 dark:hover:bg-gray-500 transition-colors duration-150">Batal</a>
            <button type="submit"
                class="ml-3 inline-flex items-center px-6 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-sm text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-800 focus:outline-none focus:border-blue-800 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">Simpan
                Proyek</button>
        </div>
    </form>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const lokasiData = {
                "Tarogong Kidul": ["Jayawaras", "Sukakarya", "Sukajaya", "Tarogong", "Sukagalih", "Jayaraga"],
                "Tarogong Kaler": ["Cimanganten", "Pananjung", "Sirnajaya", "Pasawahan", "Langensari",
                    "Mekarjaya"
                ],
                "Garut Kota": ["Kota Kulon", "Kota Wetan", "Margawati", "Sukaratu", "Cimuncang", "Pakuncen",
                    "Paminggir", "Regol"
                ],
                "Karangpawitan": ["Karangpawitan", "Lebakjaya", "Situsaeur", "Sindanglaya", "Sanding", "Godog",
                    "Sukamulya"
                ],
                "Banyuresmi": ["Banyuresmi", "Bagendit", "Cipicung", "Karyasari", "Sukakarya", "Sukasenang"],
                "Leles": ["Leles", "Cangkuang", "Ciburial", "Dano", "Haruman", "Jangkurang", "Salamnunggal"],
                // Tambahkan kecamatan dan desa lain di Garut jika diperlukan
            };

            const kecamatanSelect = document.getElementById('kecamatan');
            const desaSelect = document.getElementById('desa');
            const oldKecamatan = "{{ old('kecamatan') }}";

            // Isi dropdown kecamatan
            Object.keys(lokasiData).sort().forEach(kecamatan => {
                const option = document.createElement('option');
                option.value = kecamatan;
                option.textContent = kecamatan;
                if (kecamatan === oldKecamatan) {
                    option.selected = true;
                }
                kecamatanSelect.appendChild(option);
            });

            function populateDesa(selectedKecamatan) {
                const oldDesa = "{{ old('desa') }}";
                desaSelect.innerHTML = '<option value="">-- Pilih Desa/Kelurahan --</option>';
                desaSelect.disabled = true;

                if (selectedKecamatan && lokasiData[selectedKecamatan]) {
                    desaSelect.disabled = false;
                    lokasiData[selectedKecamatan].sort().forEach(desa => {
                        const option = document.createElement('option');
                        option.value = desa;
                        option.textContent = desa;
                        if (desa === oldDesa) {
                            option.selected = true;
                        }
                        desaSelect.appendChild(option);
                    });
                }
            }

            kecamatanSelect.addEventListener('change', function() {
                populateDesa(this.value);
            });

            // Populate desa if an old kecamatan value exists on page load (for validation errors)
            if (oldKecamatan) {
                populateDesa(oldKecamatan);
            }
        });
    </script>
@endpush
