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

                    {{-- Menampilkan Error Validasi --}}
                    @if ($errors->any())
                        <div
                            class="mb-4 p-4 text-sm text-red-700 bg-red-100 rounded-lg dark:bg-red-900/30 dark:text-red-300">
                            <span class="font-medium">Oops! Ada beberapa kesalahan:</span>
                            <ul class="mt-1.5 list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- Menampilkan Catatan Admin --}}
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
                        @method('PUT')

                        <!-- Tanggal Laporan -->
                        <div class="mb-6">
                            <label for="tanggal_laporan"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tanggal
                                Laporan</label>
                            <input type="date" id="tanggal_laporan" name="tanggal_laporan"
                                value="{{ old('tanggal_laporan', $report->tanggal_laporan) }}"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-sky-500 focus:border-sky-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-sky-500 dark:focus:border-sky-500"
                                required>
                        </div>

                        <hr class="my-6 border-gray-200 dark:border-gray-700">

                        <h3 class="text-lg font-semibold mb-3 dark:text-white">Item Pekerjaan</h3>
                        <div id="report-items-container" class="space-y-6">
                            @forelse (old('items', $report->reportItems->toArray()) as $index => $item)
                                <div class="report-item p-4 border border-gray-300 dark:border-gray-600 rounded-lg space-y-3"
                                    data-item-index="{{ $index }}">
                                    <div class="flex justify-between items-center">
                                        <h4 class="text-md font-medium dark:text-white">Item Pekerjaan #<span
                                                class="item-number">{{ $index + 1 }}</span></h4>
                                        <button type="button"
                                            class="remove-item-btn text-red-500 hover:text-red-700 text-sm font-medium">&times;
                                            Hapus Item</button>
                                    </div>
                                    <div>
                                        <label for="items_{{ $index }}_jenis_pekerjaan"
                                            class="block mb-1 text-xs font-medium text-gray-900 dark:text-white">Jenis
                                            Pekerjaan</label>
                                        <select name="items[{{ $index }}][jenis_pekerjaan]"
                                            id="items_{{ $index }}_jenis_pekerjaan"
                                            class="jenis-pekerjaan-select bg-gray-50 border ... block w-full ..."
                                            required>
                                            <option value="">-- Pilih Jenis Pekerjaan --</option>
                                            @foreach ($jenisPekerjaanOptions as $option)
                                                <option value="{{ $option }}"
                                                    {{ ($item['jenis_pekerjaan'] ?? '') == $option ? 'selected' : '' }}>
                                                    {{ $option }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-3 dimension-inputs">
                                        <div>
                                            <label for="items_{{ $index }}_panjang"
                                                class="block mb-1 text-xs font-medium text-gray-900 dark:text-white">Panjang
                                                (m)</label>
                                            <input type="number" step="0.01"
                                                name="items[{{ $index }}][panjang]"
                                                id="items_{{ $index }}_panjang"
                                                value="{{ $item['panjang'] ?? '' }}" placeholder="0.00"
                                                class="panjang-input bg-gray-50 border ... block w-full ...">
                                        </div>
                                        <div>
                                            <label for="items_{{ $index }}_lebar"
                                                class="block mb-1 text-xs font-medium text-gray-900 dark:text-white">Lebar
                                                (m)</label>
                                            <input type="number" step="0.01"
                                                name="items[{{ $index }}][lebar]"
                                                id="items_{{ $index }}_lebar"
                                                value="{{ $item['lebar'] ?? '' }}" placeholder="0.00"
                                                class="lebar-input bg-gray-50 border ... block w-full ...">
                                        </div>
                                        <div>
                                            <label for="items_{{ $index }}_tinggi_atau_tebal"
                                                class="block mb-1 text-xs font-medium text-gray-900 dark:text-white">Tinggi/Tebal
                                                (m)</label>
                                            <input type="number" step="0.01"
                                                name="items[{{ $index }}][tinggi_atau_tebal]"
                                                id="items_{{ $index }}_tinggi_atau_tebal"
                                                value="{{ $item['tinggi_atau_tebal'] ?? '' }}" placeholder="0.00"
                                                class="tinggi-input bg-gray-50 border ... block w-full ...">
                                        </div>
                                    </div>
                                    <div class="mt-2 text-sm dark:text-gray-300">
                                        <span class="font-medium">Estimasi Volume: </span>
                                        <span class="volume-display">0.00</span> <span class="satuan-display"></span>
                                    </div>
                                    <div>
                                        <label for="items_{{ $index }}_catatan_item"
                                            class="block mb-1 text-xs font-medium text-gray-900 dark:text-white">Catatan
                                            Item (Opsional)</label>
                                        <textarea name="items[{{ $index }}][catatan_item]" id="items_{{ $index }}_catatan_item" rows="2"
                                            placeholder="Catatan tambahan untuk item ini..." class="bg-gray-50 border ... block w-full ...">{{ $item['catatan_item'] ?? '' }}</textarea>
                                    </div>
                                </div>
                            @empty
                                {{-- Biarkan kosong, JavaScript akan menambah item pertama jika tidak ada --}}
                            @endforelse
                        </div>

                        <button type="button" id="add-item-btn"
                            class="mt-4 text-sm text-sky-600 dark:text-sky-400 hover:underline font-medium">
                            + Tambah Item Pekerjaan Lain
                        </button>

                        <div
                            class="flex items-center justify-end mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
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
                let itemIndex = {{ count(old('items', $report->reportItems->toArray())) }};

                const jenisPekerjaanConfig = @json(config('your_config_file.jenis_pekerjaan_config')); // Ganti dengan config Anda jika ada

                const jenisPekerjaanOptionsPHP = @json($jenisPekerjaanOptions ?? []);
                let jenisPekerjaanOptionsHTML = '<option value="">-- Pilih Jenis Pekerjaan --</option>';
                jenisPekerjaanOptionsPHP.forEach(option => {
                    jenisPekerjaanOptionsHTML += `<option value="${option}">${option}</option>`;
                });

                function initializeItemEventListeners(itemElement) {
                    // ... (Fungsi ini tetap sama seperti di Canvas sebelumnya)
                }

                function updateItemIndices() {
                    const allItems = itemsContainer.querySelectorAll('.report-item');
                    allItems.forEach((item, idx) => {
                        item.querySelector('.item-number').textContent = idx + 1;
                        item.setAttribute('data-item-index', idx);
                        item.querySelectorAll('[name]').forEach(el => {
                            el.name = el.name.replace(/items\[\d+\]/g, `items[${idx}]`);
                            if (el.id) {
                                el.id = el.id.replace(/items_\d+_/g, `items_${idx}_`);
                            }
                        });
                        item.querySelectorAll('label[for]').forEach(label => {
                            if (label.htmlFor) {
                                label.htmlFor = label.htmlFor.replace(/items_\d+_/g, `items_${idx}_`);
                            }
                        });
                    });
                }

                function addNewItem() {
                    const newIndex = itemIndex++;
                    const template = document.createElement('div');
                    template.classList.add('report-item', 'p-4', 'border', 'border-gray-300', 'dark:border-gray-600',
                        'rounded-lg', 'space-y-3');
                    template.setAttribute('data-item-index', newIndex);
                    template.innerHTML = `
                    <div class="flex justify-between items-center">
                        <h4 class="text-md font-medium dark:text-white">Item Pekerjaan #<span class="item-number">${newIndex + 1}</span></h4>
                        <button type="button" class="remove-item-btn text-red-500 hover:text-red-700 text-sm font-medium">&times; Hapus Item</button>
                    </div>
                    <div>
                        <label for="items_${newIndex}_jenis_pekerjaan" class="block mb-1 text-xs font-medium text-gray-900 dark:text-white">Jenis Pekerjaan</label>
                        <select name="items[${newIndex}][jenis_pekerjaan]" id="items_${newIndex}_jenis_pekerjaan" class="jenis-pekerjaan-select bg-gray-50 border ... block w-full ..." required>${jenisPekerjaanOptionsHTML}</select>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-3 dimension-inputs hidden">
                        <div>
                            <label for="items_${newIndex}_panjang" class="block ...">Panjang (m)</label>
                            <input type="number" step="0.01" name="items[${newIndex}][panjang]" id="items_${newIndex}_panjang" placeholder="0.00" class="panjang-input bg-gray-50 border ... block w-full ...">
                        </div>
                        <div>
                            <label for="items_${newIndex}_lebar" class="block ...">Lebar (m)</label>
                            <input type="number" step="0.01" name="items[${newIndex}][lebar]" id="items_${newIndex}_lebar" placeholder="0.00" class="lebar-input bg-gray-50 border ... block w-full ...">
                        </div>
                        <div>
                            <label for="items_${newIndex}_tinggi_atau_tebal" class="block ...">Tinggi/Tebal (m)</label>
                            <input type="number" step="0.01" name="items[${newIndex}][tinggi_atau_tebal]" id="items_${newIndex}_tinggi_atau_tebal" placeholder="0.00" class="tinggi-input bg-gray-50 border ... block w-full ...">
                        </div>
                    </div>
                    <div class="mt-2 text-sm dark:text-gray-300">
                        <span class="font-medium">Estimasi Volume: </span><span class="volume-display">0.00</span> <span class="satuan-display"></span>
                    </div>
                    <div>
                        <label for="items_${newIndex}_catatan_item" class="block ...">Catatan Item (Opsional)</label>
                        <textarea name="items[${newIndex}][catatan_item]" id="items_${newIndex}_catatan_item" rows="2" class="bg-gray-50 border ... block w-full ..."></textarea>
                    </div>
                `;
                    itemsContainer.appendChild(template);
                    initializeItemEventListeners(template);
                    updateRemoveButtonsVisibility();
                }

                // ... (Fungsi updateRemoveButtonsVisibility dan event listener untuk addItemBtn tetap sama)

                // Inisialisasi untuk item yang sudah ada
                itemsContainer.querySelectorAll('.report-item').forEach(item => {
                    initializeItemEventListeners(item);
                });

                // Jika tidak ada item sama sekali saat load, tambahkan satu
                if (itemsContainer.querySelectorAll('.report-item').length === 0) {
                    addNewItem();
                }

                updateRemoveButtonsVisibility();
            });
        </script>
    @endpush
</x-app-layout>
