<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Buat Laporan Harian untuk Proyek: ') }} <span class="font-bold">{{ $project->nama_proyek }}</span>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if (session('error'))
                        <div class="mb-4 p-4 text-sm text-red-700 bg-red-100 rounded-lg dark:bg-red-200 dark:text-white"
                            role="alert">
                            <span class="font-medium">Error!</span> {{ session('error') }}
                        </div>
                    @endif
                    @if ($errors->any())
                        <div
                            class="mb-4 p-4 text-sm text-red-700 bg-red-100 rounded-lg dark:bg-red-200 dark:text-white">
                            <span class="font-medium">Oops! Ada beberapa kesalahan:</span>
                            <ul class="mt-1.5 list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('pelaksana.laporan.store', $project->id) }}">
                        @csrf

                        <div class="mb-6">
                            <label for="tanggal_laporan"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tanggal
                                Laporan</label>
                            <input type="date" id="tanggal_laporan" name="tanggal_laporan"
                                value="{{ old('tanggal_laporan', date('Y-m-d')) }}"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-sky-500 focus:border-sky-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-sky-500 dark:focus:border-sky-500"
                                required>
                            @error('tanggal_laporan')
                                <p class="mt-2 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <hr class="my-6 border-gray-200 dark:border-gray-700">

                        <h3 class="text-lg font-semibold mb-3 dark:text-white">Item Pekerjaan</h3>
                        <div id="report-items-container" class="space-y-6">
                            <div class="report-item p-4 border border-gray-300 dark:border-gray-600 rounded-lg space-y-3"
                                data-item-index="0">
                                <div class="flex justify-between items-center">
                                    <h4 class="text-mb font-medium dark:text-white">Item Pekerjaan #<span class="item-number">1</span>
                                    </h4>
                                    <button type="button"
                                        class="remove-item-btn text-red-500 hover:text-red-700 text-sm font-medium hidden">&times;
                                        Hapus Item</button>
                                </div>

                                <div>
                                    <label for="items[0][jenis_pekerjaan]"
                                        class="block mb-1 text-xs font-medium text-gray-900 dark:text-white">Jenis
                                        Pekerjaan</label>
                                    <select name="items[0][jenis_pekerjaan]"
                                        class="jenis-pekerjaan-select bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-sky-500 focus:border-sky-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-sky-500 dark:focus:border-sky-500"
                                        required>
                                        <option value="">-- Pilih Jenis Pekerjaan --</option>
                                        @foreach ($jenisPekerjaanOptions as $option)
                                            <option value="{{ $option }}">{{ $option }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-3 gap-3 dimension-inputs hidden">
                                    <div>
                                        <label for="items[0][panjang]"
                                            class="block mb-1 text-xs font-medium text-gray-900 dark:text-white">Panjang
                                            (m)</label>
                                        <input type="number" step="0.01" name="items[0][panjang]" placeholder="0.00"
                                            class="panjang-input bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-sky-500 focus:border-sky-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-sky-500 dark:focus:border-sky-500">
                                    </div>
                                    <div>
                                        <label for="items[0][lebar]"
                                            class="block mb-1 text-xs font-medium text-gray-900 dark:text-white">Lebar
                                            (m)</label>
                                        <input type="number" step="0.01" name="items[0][lebar]" placeholder="0.00"
                                            class="lebar-input bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-sky-500 focus:border-sky-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-sky-500 dark:focus:border-sky-500">
                                    </div>
                                    <div>
                                        <label for="items[0][tinggi_atau_tebal]"
                                            class="block mb-1 text-xs font-medium text-gray-900 dark:text-white">Tinggi/Tebal
                                            (m)</label>
                                        <input type="number" step="0.01" name="items[0][tinggi_atau_tebal]"
                                            placeholder="0.00"
                                            class="tinggi-input bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-sky-500 focus:border-sky-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-sky-500 dark:focus:border-sky-500">
                                    </div>
                                </div>

                                <div class="mt-2 text-sm dark:text-white">
                                    <span class="font-medium">Estimasi Volume: </span>
                                    <span class="volume-display">0.00</span> <span class="satuan-display"></span>
                                </div>

                                <div>
                                    <label for="items[0][catatan_item]"
                                        class="block mb-1 text-xs font-medium text-gray-900 dark:text-white">Catatan
                                        Item (Opsional)</label>
                                    <textarea name="items[0][catatan_item]" rows="2" placeholder="Catatan tambahan untuk item ini..."
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-sky-500 focus:border-sky-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-sky-500 dark:focus:border-sky-500"></textarea>
                                </div>
                            </div>
                        </div>

                        <button type="button" id="add-item-btn"
                            class="mt-4 text-sm text-sky-600 dark:text-white hover:underline font-medium">
                            + Tambah Item Pekerjaan Lain
                        </button>

                        <hr class="my-6 border-gray-200 dark:border-gray-700">

                        <div class="flex items-center justify-end mt-6">
                            <a href="{{ route('pelaksana.projects.index') }}"
                                class="text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white underline mr-4">
                                Batal
                            </a>
                            <button type="submit"
                                class="px-6 py-2.5 text-sm font-medium text-center text-white bg-sky-600 rounded-lg hover:bg-sky-700 focus:ring-4 focus:outline-none focus:ring-sky-300 dark:bg-sky-500 dark:hover:bg-sky-600 dark:focus:ring-sky-800">
                                Simpan Laporan Harian
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        {{-- Atau letakkan script ini sebelum </body> jika tidak pakai @push --}}
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const itemsContainer = document.getElementById('report-items-container');
                const addItemBtn = document.getElementById('add-item-btn');
                let itemIndex = 0; // Dimulai dari 0 untuk item pertama

                // Konfigurasi jenis pekerjaan dan input yang dibutuhkan (sinkronkan dengan backend)
                const jenisPekerjaanConfig = {
                    'Pembersihan Lokasi': ['panjang', 'lebar'],
                    'Leveling Rataan': ['panjang', 'lebar', 'tinggi'],
                    'Urugan Sirtu (Begisting)': ['panjang', 'lebar', 'tinggi'], // Perlu klarifikasi rumus
                    'Alas Plastik': ['panjang', 'lebar'],
                    'Cor Beton': ['panjang', 'lebar', 'tinggi'],
                };

                function initializeItemEventListeners(itemElement) {
                    const jenisPekerjaanSelect = itemElement.querySelector('.jenis-pekerjaan-select');
                    const dimensionInputsContainer = itemElement.querySelector('.dimension-inputs');
                    const panjangInput = itemElement.querySelector('.panjang-input');
                    const lebarInput = itemElement.querySelector('.lebar-input');
                    const tinggiInput = itemElement.querySelector('.tinggi-input'); // tinggi_atau_tebal
                    const volumeDisplay = itemElement.querySelector('.volume-display');
                    const satuanDisplay = itemElement.querySelector('.satuan-display');
                    const removeItemBtn = itemElement.querySelector('.remove-item-btn');

                    function updateDimensionVisibility() {
                        const selectedJenis = jenisPekerjaanSelect.value;
                        const neededInputs = jenisPekerjaanConfig[selectedJenis] || [];

                        // Sembunyikan semua input dimensi dulu
                        dimensionInputsContainer.classList.add('hidden');
                        if (panjangInput) panjangInput.parentElement.classList.add('hidden');
                        if (lebarInput) lebarInput.parentElement.classList.add('hidden');
                        if (tinggiInput) tinggiInput.parentElement.classList.add('hidden');

                        if (selectedJenis && neededInputs.length > 0) {
                            dimensionInputsContainer.classList.remove('hidden');
                            if (neededInputs.includes('panjang') && panjangInput) panjangInput.parentElement.classList
                                .remove('hidden');
                            if (neededInputs.includes('lebar') && lebarInput) lebarInput.parentElement.classList.remove(
                                'hidden');
                            if (neededInputs.includes('tinggi') && tinggiInput) tinggiInput.parentElement.classList
                                .remove('hidden'); // 'tinggi' atau 'tinggi_atau_tebal'
                        }
                        calculateVolume(); // Hitung ulang saat jenis pekerjaan berubah
                    }

                    function calculateVolume() {
                        const jenis = jenisPekerjaanSelect.value;
                        const p = parseFloat(panjangInput.value) || 0;
                        const l = parseFloat(lebarInput.value) || 0;
                        const t = parseFloat(tinggiInput.value) || 0;
                        let vol = 0;
                        let satuan = '-';

                        if (!jenis) {
                            volumeDisplay.textContent = '0.00';
                            satuanDisplay.textContent = '';
                            return;
                        }

                        if (jenis === 'Pembersihan Lokasi' || jenis === 'Alas Plastik') {
                            vol = p * l;
                            satuan = 'm²';
                        } else if (['Leveling Rataan', 'Cor Beton', 'Urugan Sirtu (Begisting)'].includes(jenis)) {
                            // Ingat: Urugan Sirtu perlu klarifikasi rumus. Saat ini sama dengan Cor Beton.
                            vol = p * l * t;
                            satuan = 'm³';
                        }
                        // Tambahkan jenis pekerjaan lain

                        volumeDisplay.textContent = vol.toFixed(2);
                        satuanDisplay.textContent = satuan;
                    }

                    jenisPekerjaanSelect.addEventListener('change', updateDimensionVisibility);
                    [panjangInput, lebarInput, tinggiInput].forEach(input => {
                        if (input) input.addEventListener('input', calculateVolume);
                    });

                    if (removeItemBtn) {
                        removeItemBtn.addEventListener('click', function() {
                            itemElement.remove();
                            updateRemoveButtonsVisibility();
                        });
                    }
                    updateDimensionVisibility(); // Panggil saat inisialisasi juga
                }

                function addNewItem() {
                    itemIndex++;
                    const template = itemsContainer.querySelector(
                        '.report-item[data-item-index="0"]'); // Ambil template dari item pertama
                    const newItem = template.cloneNode(true);

                    newItem.setAttribute('data-item-index', itemIndex);
                    newItem.querySelector('.item-number').textContent = itemIndex + 1;

                    // Update name attributes for new item
                    newItem.querySelectorAll('[name]').forEach(el => {
                        el.name = el.name.replace(/items\[0\]/g, `items[${itemIndex}]`);
                        // Reset value untuk input baru, kecuali jenis pekerjaan jika ingin default
                        if (el.tagName === 'INPUT' && el.type !== 'hidden' || el.tagName === 'TEXTAREA') el
                            .value = '';
                        if (el.tagName === 'SELECT') el.selectedIndex = 0; // Reset select
                    });

                    // Reset tampilan volume dan satuan
                    newItem.querySelector('.volume-display').textContent = '0.00';
                    newItem.querySelector('.satuan-display').textContent = '';

                    // Sembunyikan input dimensi di item baru sampai jenis pekerjaan dipilih
                    const dimensionInputsContainerNew = newItem.querySelector('.dimension-inputs');
                    if (dimensionInputsContainerNew) dimensionInputsContainerNew.classList.add('hidden');

                    itemsContainer.appendChild(newItem);
                    initializeItemEventListeners(newItem);
                    updateRemoveButtonsVisibility();
                }

                function updateRemoveButtonsVisibility() {
                    const allItems = itemsContainer.querySelectorAll('.report-item');
                    allItems.forEach((item, index) => {
                        const btn = item.querySelector('.remove-item-btn');
                        if (btn) {
                            if (allItems.length > 1) {
                                btn.classList.remove('hidden');
                            } else {
                                btn.classList.add('hidden');
                            }
                        }
                    });
                }

                addItemBtn.addEventListener('click', addNewItem);

                // Initialize event listeners for the first item
                const firstItem = itemsContainer.querySelector('.report-item');
                if (firstItem) {
                    initializeItemEventListeners(firstItem);
                }
                updateRemoveButtonsVisibility(); // Panggil saat load
            });
        </script>
    @endpush
</x-app-layout>

{{-- // Catatan: Pastikan layout Anda (`layouts.app` atau `layouts.pelaksana_app`) memiliki section `@stack('scripts')`
// sebelum tag penutup </body> jika Anda menggunakan `@push('scripts')`. Jika tidak,
    // letakkan tag `
    <script>
        ...
    </script>` JavaScript langsung sebelum `</body>`. --}}
