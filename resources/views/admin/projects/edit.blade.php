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

        {{-- Detail Proyek --}}
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="nama_proyek" class="block font-medium text-sm text-gray-700 dark:text-gray-300 mb-1">Nama
                        Proyek</label>
                    <input id="nama_proyek" type="text" name="nama_proyek"
                        value="{{ old('nama_proyek', $project->nama_proyek) }}" required autofocus
                        class="block w-full rounded-md shadow-sm border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                </div>
                <div>
                    <label for="jenis_proyek" class="block font-medium text-sm text-gray-700 dark:text-gray-300 mb-1">Jenis
                        Proyek</label>
                    <select id="jenis_proyek" name="jenis_proyek" required
                        class="block w-full rounded-md shadow-sm border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        <option value="">-- Pilih Jenis Proyek --</option>
                        <option value="Pembangunan Jalan Baru"
                            {{ old('jenis_proyek', $project->jenis_proyek) == 'Pembangunan Jalan Baru' ? 'selected' : '' }}>
                            Pembangunan Jalan Baru</option>
                        <option value="Perbaikan Jalan"
                            {{ old('jenis_proyek', $project->jenis_proyek) == 'Perbaikan Jalan' ? 'selected' : '' }}>
                            Perbaikan Jalan</option>
                        <option value="Pelebaran Jalan Desa"
                            {{ old('jenis_proyek', $project->jenis_proyek) == 'Pelebaran Jalan Desa' ? 'selected' : '' }}>
                            Pelebaran Jalan Desa</option>
                        <option value="Pengaspalan Ulang"
                            {{ old('jenis_proyek', $project->jenis_proyek) == 'Pengaspalan Ulang' ? 'selected' : '' }}>
                            Pengaspalan Ulang</option>
                        <option value="Pengecoran Jalan"
                            {{ old('jenis_proyek', $project->jenis_proyek) == 'Pengecoran Jalan' ? 'selected' : '' }}>
                            Pengecoran Jalan</option>
                    </select>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="kecamatan"
                        class="block font-medium text-sm text-gray-700 dark:text-gray-300 mb-1">Kecamatan</label>
                    <select id="kecamatan" name="kecamatan" required
                        class="block w-full rounded-md shadow-sm border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        <option value="">-- Pilih Kecamatan --</option>
                    </select>
                </div>
                <div>
                    <label for="desa"
                        class="block font-medium text-sm text-gray-700 dark:text-gray-300 mb-1">Desa/Kelurahan</label>
                    <select id="desa" name="desa" required
                        class="block w-full rounded-md shadow-sm border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        <option value="">-- Pilih Kecamatan Terlebih Dahulu --</option>
                    </select>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="tanggal_mulai"
                        class="block font-medium text-sm text-gray-700 dark:text-gray-300 mb-1">Tanggal Mulai</label>
                    <input id="tanggal_mulai" type="date" name="tanggal_mulai"
                        value="{{ old('tanggal_mulai', $project->tanggal_mulai) }}" required
                        class="block w-full rounded-md shadow-sm border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                </div>
                <div>
                    <label for="tanggal_selesai"
                        class="block font-medium text-sm text-gray-700 dark:text-gray-300 mb-1">Tanggal Selesai</label>
                    <input id="tanggal_selesai" type="date" name="tanggal_selesai"
                        value="{{ old('tanggal_selesai', $project->tanggal_selesai) }}" required
                        class="block w-full rounded-md shadow-sm border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                </div>
            </div>
        </div>

        {{-- Penugasan Pelaksana --}}
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md">
            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">Tugaskan Pelaksana</h3>
            <div>
                <label for="pelaksana_ids" class="block font-medium text-sm text-gray-700 dark:text-gray-300 mb-1">Pilih
                    Pelaksana (bisa lebih dari satu):</label>
                <select name="pelaksana_ids[]" id="pelaksana_ids" multiple
                    class="block w-full h-40 rounded-md shadow-sm border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    @foreach ($pelaksanas as $pelaksana)
                        <option value="{{ $pelaksana->id }}"
                            {{ in_array($pelaksana->id, old('pelaksana_ids', $assignedPelaksanaIds ?? [])) ? 'selected' : '' }}>
                            {{ $pelaksana->name }} ({{ $pelaksana->email }})
                        </option>
                    @endforeach
                </select>
                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Tahan Ctrl (atau Cmd di Mac) untuk memilih lebih
                    dari satu.</p>
                @error('pelaksana_ids.*')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="flex items-center justify-end pt-4">
            <a href="{{ route('admin.projects.index') }}"
                class="px-6 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 dark:bg-gray-600 dark:text-gray-200 dark:border-gray-500 dark:hover:bg-gray-500 transition-colors duration-150">Batal</a>
            <button type="submit"
                class="ml-3 inline-flex items-center px-6 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-sm text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-800 focus:outline-none focus:border-blue-800 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">Update
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
            };

            const kecamatanSelect = document.getElementById('kecamatan');
            const desaSelect = document.getElementById('desa');
            const initialKecamatan = "{{ old('kecamatan', $kecamatan) }}";
            const initialDesa = "{{ old('desa', $desa) }}";

            // Isi dropdown kecamatan
            Object.keys(lokasiData).sort().forEach(kecamatan => {
                const option = document.createElement('option');
                option.value = kecamatan;
                option.textContent = kecamatan;
                if (kecamatan === initialKecamatan) {
                    option.selected = true;
                }
                kecamatanSelect.appendChild(option);
            });

            function populateDesa(selectedKecamatan) {
                const currentSelectedDesa = initialDesa;
                desaSelect.innerHTML = '<option value="">-- Pilih Desa/Kelurahan --</option>';
                desaSelect.disabled = true;

                if (selectedKecamatan && lokasiData[selectedKecamatan]) {
                    desaSelect.disabled = false;
                    lokasiData[selectedKecamatan].sort().forEach(desa => {
                        const option = document.createElement('option');
                        option.value = desa;
                        option.textContent = desa;
                        if (desa === currentSelectedDesa) {
                            option.selected = true;
                        }
                        desaSelect.appendChild(option);
                    });
                }
            }

            kecamatanSelect.addEventListener('change', function() {
                // Saat kecamatan diubah, kita anggap desa harus dipilih ulang
                desaSelect.innerHTML = '<option value="">-- Pilih Desa/Kelurahan --</option>';
                if (this.value && lokasiData[this.value]) {
                    desaSelect.disabled = false;
                    lokasiData[this.value].sort().forEach(desa => {
                        const option = document.createElement('option');
                        option.value = desa;
                        option.textContent = desa;
                        desaSelect.appendChild(option);
                    });
                } else {
                    desaSelect.disabled = true;
                }
            });

            if (initialKecamatan) {
                populateDesa(initialKecamatan);
            }
        });
    </script>
@endpush
