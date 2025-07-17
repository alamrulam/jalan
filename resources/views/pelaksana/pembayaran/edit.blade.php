@extends('layouts.app')
@section('header')
    <h2 class="font-semibold text-xl ...">
        {{ isset($pembayaran) ? 'Edit' : 'Catat' }} Pembayaran untuk Proyek: {{ $project->nama_proyek }}
    </h2>
@endsection

@section('content')
    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md">
                <form method="POST" action="{{ isset($pembayaran) ? route('pelaksana.projects.pembayaran.update', [$project->id, $pembayaran->id]) : route('pelaksana.projects.pembayaran.store', $project->id) }}">
                    @csrf
                    @if(isset($pembayaran))
                        @method('PUT')
                    @endif
                    
                    {{-- Dropdown Jenis Pekerjaan --}}
                    <div>
                        <label for="jenis_pekerjaan_id">Kelompok Pekerjaan</label>
                        <select id="jenis_pekerjaan_id" name="jenis_pekerjaan_id" required>
                            <option value="">-- Pilih Kelompok Pekerjaan --</option>
                            @foreach($jenisPekerjaanOptions as $id => $nama)
                                <option value="{{ $id }}" {{ old('jenis_pekerjaan_id', $pembayaran->jenis_pekerjaan_id ?? '') == $id ? 'selected' : '' }}>
                                    {{ $nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Dropdown Jenis Transaksi --}}
                    <div>
                        <label for="jenis_transaksi">Jenis Transaksi</label>
                        <select id="jenis_transaksi" name="jenis_transaksi" required>
                            <option value="">-- Pilih Jenis Transaksi --</option>
                            <option value="Material" {{ old('jenis_transaksi', $pembayaran->jenis_transaksi ?? '') == 'Material' ? 'selected' : '' }}>Material</option>
                            <option value="Upah Tenaga Kerja" {{ old('jenis_transaksi', $pembayaran->jenis_transaksi ?? '') == 'Upah Tenaga Kerja' ? 'selected' : '' }}>Upah Tenaga Kerja</option>
                            <option value="Sewa Alat" {{ old('jenis_transaksi', $pembayaran->jenis_transaksi ?? '') == 'Sewa Alat' ? 'selected' : '' }}>Sewa Alat</option>
                            <option value="Jasa Konsultan" {{ old('jenis_transaksi', $pembayaran->jenis_transaksi ?? '') == 'Jasa Konsultan' ? 'selected' : '' }}>Jasa Konsultan</option>
                        </select>
                    </div>

                    {{-- Input Tanggal, Keterangan, Jumlah --}}
                    <div>
                        <label for="tanggal_pembayaran">Tanggal</label>
                        <input id="tanggal_pembayaran" type="date" name="tanggal_pembayaran" value="{{ old('tanggal_pembayaran', $pembayaran->tanggal_pembayaran ?? date('Y-m-d')) }}" required>
                    </div>
                    <div>
                        <label for="keterangan">Keterangan</label>
                        <textarea id="keterangan" name="keterangan" rows="3" required>{{ old('keterangan', $pembayaran->keterangan ?? '') }}</textarea>
                    </div>
                    <div>
                        <label for="jumlah">Jumlah (Rp)</label>
                        <input id="jumlah" type="number" name="jumlah" value="{{ old('jumlah', $pembayaran->jumlah ?? '') }}" required>
                    </div>

                    <div class="flex items-center justify-end mt-6">
                        <a href="{{ route('pelaksana.projects.pembayaran.index', $project->id) }}" class="...">Batal</a>
                        <button type="submit" class="ml-3 ...">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection