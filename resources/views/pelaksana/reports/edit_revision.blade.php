<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Revisi Laporan Harian untuk Proyek: ') }} <span class="font-bold">{{ $project->nama_proyek }}</span>
            (Laporan #{{ $report->id }})
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if (session('error'))
                        <div class="mb-4 p-4 text-sm text-red-700 bg-red-100 rounded-lg dark:bg-red-200 dark:text-red-800"
                            role="alert">
                            <span class="font-medium">Error!</span> {{ session('error') }}
                        </div>
                    @endif
                    @if ($errors->any())
                        <div
                            class="mb-4 p-4 text-sm text-red-700 bg-red-100 rounded-lg dark:bg-red-200 dark:text-red-800">
                            <span class="font-medium">Oops! Ada beberapa kesalahan:</span>
                            <ul class="mt-1.5 list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- Tampilkan Catatan Admin Jika Ada --}}
                    @if ($report->catatan_admin)
                        <div
                            class="mb-6 p-4 border border-yellow-300 bg-yellow-50 dark:bg-yellow-700/30 dark:border-yellow-600 rounded-md">
                            <h4 class="text-sm font-semibold text-yellow-800 dark:text-yellow-200">Catatan dari Admin
                                (Alasan Penolakan Sebelumnya):</h4>
                            <p class="mt-1 text-sm text-yellow-700 dark:text-yellow-300 whitespace-pre-wrap">
                                {{ $report->catatan_admin }}</p>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('pelaksana.reports.updateRevision', $report->id) }}">
                        @csrf
                        @method('PUT') {{-- Method untuk update --}}

                        <div class="mb-6">
                            <label for="tanggal_laporan"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tanggal
                                Laporan</label>
                            <input type="date" id="tanggal_laporan" name="tanggal_laporan"
                                value="{{ old('tanggal_laporan', $report->tanggal_laporan) }}"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-sky-500 focus:border-sky-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-sky-500 dark:focus:border-sky-500"
                                required>
                            @error('tanggal_laporan')
                                <p class="mt-2 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <hr class="my-6 border-gray-200 dark:border-gray-700">

                        <h3 class="text-lg font-semibold mb-3">Item Pekerjaan</h3>
                        <div id="report-items-container" class="space-y-6">
                            {{-- Loop untuk item yang sudah ada --}}
                            @forelse ($report->reportItems as $index => $existingItem)
                                <div class="report-item p-4 border border-gray-300 dark:border-gray-600 rounded-lg space-y-3"
                                    data-item-index="{{ $index }}">
                                    <div class="flex justify-between items-center">
                                        <h4 class="text-md font-medium">Item Pekerjaan #<span
                                                class="item-number">{{ $index + 1 }}</span></h4>
                                        <button type="button"
                                            class="remove-item-btn text-red-500 hover:text-red-700 text-sm font-medium {{ $report->reportItems->count() == 1 && $loop->first ? 'hidden' : '' }}">&times;
                                            Hapus Item</button>
                                    </div>
                                    <div>
                                        <label for="items[{{ $index }}][jenis_pekerjaan]"
                                            class="block mb-1 text-xs font-medium text-gray-900 dark:text-white">Jenis
                                            Pekerjaan</label>
                                        <select name="items[{{ $index }}][jenis_pekerjaan]"
                                            id="items_{{ $index }}_jenis_pekerjaan"
                                            class="jenis-pekerjaan-select bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-sky-500 focus:border-sky-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                            required>
                                            <option value="">-- Pilih Jenis Pekerjaan --</option>
                                            @foreach ($jenisPekerjaanOptions as $option)
                                                <option value="{{ $option }}"
                                                    {{ old("items.{$index}.jenis_pekerjaan", $existingItem->jenis_pekerjaan) == $option ? 'selected' : '' }}>
                                                    {{ $option }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-3 dimension-inputs">
                                        <div>
                                            <label for="items_{{ $index }}_panjang"
                                                class="block mb-1 text-xs font-medium text-gray-900 dark:text-white">Panjang
                                                (m)
                                            </label>
                                            <input type="number" step="0.01"
                                                name="items[{{ $index }}][panjang]"
                                                id="items_{{ $index }}_panjang"
                                                value="{{ old("items.{$index}.panjang", $existingItem->panjang) }}"
                                                placeholder="0.00"
                                                class="panjang-input bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-sky-500 focus:border-sky-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                        </div>
                                        <div>
                                            <label for="items_{{ $index }}_lebar"
                                                class="block mb-1 text-xs font-medium text-gray-900 dark:text-white">Lebar
                                                (m)</label>
                                            <input type="number" step="0.01"
                                                name="items[{{ $index }}][lebar]"
                                                id="items_{{ $index }}_lebar"
                                                value="{{ old("items.{$index}.lebar", $existingItem->lebar) }}"
                                                placeholder="0.00"
                                                class="lebar-input bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-sky-500 focus:border-sky-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                        </div>
                                        <div>
                                            <label for="items_{{ $index }}_tinggi_atau_tebal"
                                                class="block mb-1 text-xs font-medium text-gray-900 dark:text-white">Tinggi/Tebal
                                                (m)</label>
                                            <input type="number" step="0.01"
                                                name="items[{{ $index }}][tinggi_atau_tebal]"
                                                id="items_{{ $index }}_tinggi_atau_tebal"
                                                value="{{ old("items.{$index}.tinggi_atau_tebal", $existingItem->tinggi_atau_tebal) }}"
                                                placeholder="0.00"
                                                class="tinggi-input bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-sky-500 focus:border-sky-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                        </div>
                                    </div>
                                    <div class="mt-2 text-sm">
                                        <span class="font-medium">Estimasi Volume: </span>
                                        <span class="volume-display">0.00</span> <span class="satuan-display"></span>
                                    </div>
                                    <div>
                                        <label for="items_{{ $index }}_catatan_item"
                                            class="block mb-1 text-xs font-medium text-gray-900 dark:text-white">Catatan
                                            Item (Opsional)</label>
                                        <textarea name="items[{{ $index }}][catatan_item]" id="items_{{ $index }}_catatan_item" rows="2"
                                            placeholder="Catatan tambahan untuk item ini..."
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-sky-500 focus:border-sky-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">{{ old("items.{$index}.catatan_item", $existingItem->catatan_item) }}</textarea>
                                    </div>
                                </div>
                            @empty
                                {{-- Jika tidak ada item sebelumnya, ini akan menjadi template untuk JS addNewItem --}}
                                {{-- Pastikan template ini memiliki semua class dan struktur yang dibutuhkan JS --}}
                                <div class="report-item p-4 border border-gray-300 dark:border-gray-600 rounded-lg space-y-3"
                                    data-item-index="0" id="report-item-template-for-empty" {{-- Beri ID unik jika ingin dikloning JS --}}
                                    {{-- style="display: none;" --}}> {{-- Bisa disembunyikan jika hanya untuk template JS --}}
                                    <div class="flex justify-between items-center">
                                        <h4 class="text-md font-medium">Item Pekerjaan #<span
                                                class="item-number">1</span></h4>
                                        <button type="button"
                                            class="remove-item-btn text-red-500 hover:text-red-700 text-sm font-medium hidden">&times;
                                            Hapus Item</button>
                                    </div>
                                    <div>
                                        <label for="items[0][jenis_pekerjaan]"
                                            class="block mb-1 text-xs font-medium text-gray-900 dark:text-white">Jenis
                                            Pekerjaan</label>
                                        <select name="items[0][jenis_pekerjaan]" id="items_0_jenis_pekerjaan"
                                            class="jenis-pekerjaan-select bg-gray-50 border ..." required>
                                            <option value="">-- Pilih Jenis Pekerjaan --</option>
                                            @foreach ($jenisPekerjaanOptions as $option)
                                                <option value="{{ $option }}">{{ $option }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-3 dimension-inputs hidden">
                                        {{-- Input Panjang, Lebar, Tinggi/Tebal --}}
                                    </div>
                                    <div class="mt-2 text-sm">
                                        <span class="font-medium">Estimasi Volume: </span>
                                        <span class="volume-display">0.00</span> <span class="satuan-display"></span>
                                    </div>
                                    <div>
                                        <label for="items_0_catatan_item"
                                            class="block mb-1 text-xs font-medium text-gray-900 dark:text-white">Catatan
                                            Item (Opsional)</label>
                                        <textarea name="items[0][catatan_item]" id="items_0_catatan_item" rows="2" placeholder="Catatan tambahan..."
                                            class="bg-gray-50 border ..."></textarea>
                                    </div>
                                </div>
                            @endforelse
                        </div>

                        <button type="button" id="add-item-btn"
                            class="mt-4 text-sm text-sky-600 dark:text-sky-400 hover:underline font-medium">
                            + Tambah Item Pekerjaan Lain
                        </button>

                        <hr class="my-6 border-gray-200 dark:border-gray-700">

                        <div class="flex items-center justify-end mt-6">
                            <a href="{{ route('pelaksana.reports.history') }}"
                                class="text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white underline mr-4">
                                Batal
                            </a>
                            <button type="submit"
                                class="px-6 py-2.5 text-sm font-medium text-center text-white bg-sky-600 rounded-lg hover:bg-sky-700 focus:ring-4 focus:outline-none focus:ring-sky-300 dark:bg-sky-500 dark:hover:bg-sky-600 dark:focus:ring-sky-800">
                                Simpan Revisi Laporan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const itemsContainer = document.getElementById('report-items-container');
                const addItemBtn = document.getElementById('add-item-btn');
                let itemIndex =
                    {{ $report->reportItems->count() > 0 ? $report->reportItems->count() - 1 : ($errors->any() && is_array(old('items')) ? count(old('items')) - 1 : -1) }};

                const jenisPekerjaanConfig = {
                    'Pembersihan Lokasi': ['panjang', 'lebar'],
                    'Leveling Rataan': ['panjang', 'lebar', 'tinggi_atau_tebal'],
                    'Urugan Sirtu (Begisting)': ['panjang', 'lebar', 'tinggi_atau_tebal'],
                    'Alas Plastik': ['panjang', 'lebar'],
                    'Cor Beton': ['panjang', 'lebar', 'tinggi_atau_tebal'],
                };

                const jenisPekerjaanOptionsHTML = `
        <option value="">-- Pilih Jenis Pekerjaan --</option>
        @foreach ($jenisPekerjaanOptions as $option)
            <option value="{{ $option }}">{{ $option }}</option>
        @endforeach
    `;

                function initializeItemEventListeners(itemElement) {
                    const jenisPekerjaanSelect = itemElement.querySelector('.jenis-pekerjaan-select');
                    const dimensionInputsContainer = itemElement.querySelector('.dimension-inputs');
                    const panjangInput = itemElement.querySelector('.panjang-input');
                    const lebarInput = itemElement.querySelector('.lebar-input');
                    const tinggiInput = itemElement.querySelector('.tinggi-input');
                    const volumeDisplay = itemElement.querySelector('.volume-display');
                    const satuanDisplay = itemElement.querySelector('.satuan-display');
                    const removeItemBtn = itemElement.querySelector('.remove-item-btn');

                    function updateDimensionVisibility() {
                        const selectedJenis = jenisPekerjaanSelect.value;
                        const neededInputsConfig = jenisPekerjaanConfig[selectedJenis] || [];

                        if (dimensionInputsContainer) {
                            Array.from(dimensionInputsContainer.children).forEach(child => child.classList.add(
                                'hidden'));
                            dimensionInputsContainer.classList.toggle('hidden', neededInputsConfig.length === 0);
                        }

                        if (selectedJenis && neededInputsConfig.length > 0) {
                            if (neededInputsConfig.includes('panjang') && panjangInput) panjangInput.parentElement
                                .classList.remove('hidden');
                            if (neededInputsConfig.includes('lebar') && lebarInput) lebarInput.parentElement.classList
                                .remove('hidden');
                            if (neededInputsConfig.includes('tinggi_atau_tebal') && tinggiInput) tinggiInput
                                .parentElement.classList.remove('hidden');
                        }
                        calculateVolume();
                    }

                    function calculateVolume() {
                        if (!jenisPekerjaanSelect || !volumeDisplay || !satuanDisplay) return;
                        const jenis = jenisPekerjaanSelect.value;
                        const p = parseFloat(panjangInput?.value) || 0;
                        const l = parseFloat(lebarInput?.value) || 0;
                        const t = parseFloat(tinggiInput?.value) || 0;
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
                            vol = p * l * t;
                            satuan = 'm³';
                        }
                        volumeDisplay.textContent = vol.toFixed(2);
                        satuanDisplay.textContent = satuan;
                    }

                    jenisPekerjaanSelect?.addEventListener('change', updateDimensionVisibility);
                    [panjangInput, lebarInput, tinggiInput].forEach(input => {
                        input?.addEventListener('input', calculateVolume);
                    });

                    removeItemBtn?.addEventListener('click', function() {
                        if (itemsContainer.querySelectorAll('.report-item').length > 1) {
                            itemElement.remove();
                            updateItemNumbers();
                            updateRemoveButtonsVisibility();
                        } else {
                            alert('Minimal harus ada satu item pekerjaan.');
                        }
                    });

                    updateDimensionVisibility();
                    calculateVolume();
                }

                function updateItemNumbers() {
                    const allItems = itemsContainer.querySelectorAll('.report-item');
                    allItems.forEach((item, idx) => {
                        item.querySelector('.item-number').textContent = idx + 1;
                        item.setAttribute('data-item-index', idx);
                        item.querySelectorAll('[name]').forEach(el => {
                            el.name = el.name.replace(/items\[\d+\]/g, `items[${idx}]`);
                            if (el.id && el.id.match(/items_\d+_/)) {
                                el.id = el.id.replace(/items_\d+_/g, `items_${idx}_`);
                            }
                        });
                        item.querySelectorAll('label[for]').forEach(label => {
                            if (label.htmlFor && label.htmlFor.match(/items_\d+_/)) {
                                label.htmlFor = label.htmlFor.replace(/items_\d+_/g, `items_${idx}_`);
                            }
                        });
                    });
                }

                function updateRemoveButtonsVisibility() {
                    const allItems = itemsContainer.querySelectorAll('.report-item');
                    allItems.forEach((item) => {
                        const btn = item.querySelector('.remove-item-btn');
                        if (btn) {
                            btn.classList.toggle('hidden', allItems.length <= 1);
                        }
                    });
                }

                function getReportItemTemplate() {
                    // Implementasi template HTML langsung atau dengan innerHTML dari elemen tersembunyi di Blade
                    // Pastikan string HTML ditutup dengan benar saat digunakan di Blade
                    const div = document.createElement('div');
                    div.classList.add('report-item');
                    div.innerHTML = `...`; // Potong untuk ringkasan
                    return div;
                }

                function addNewItem() {
                    itemIndex++;
                    const newItemElement = getReportItemTemplate();
                    newItemElement.setAttribute('data-item-index', itemIndex);
                    // Set atribut name dan id seperti sebelumnya
                    itemsContainer.appendChild(newItemElement);
                    initializeItemEventListeners(newItemElement);
                    updateRemoveButtonsVisibility();
                }

                addItemBtn?.addEventListener('click', addNewItem);

                itemsContainer.querySelectorAll('.report-item').forEach(item => {
                    initializeItemEventListeners(item);
                });

                updateRemoveButtonsVisibility();

                if (itemsContainer.querySelectorAll('.report-item').length === 0) {
                    const emptyTemplate = document.getElementById('report-item-template-for-empty');
                    if (!emptyTemplate) {
                        addNewItem();
                    }
                }
            });
        </script>
    @endpush
</x-app-layout>
