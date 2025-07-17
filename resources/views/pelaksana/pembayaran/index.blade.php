@extends('layouts.app')
@section('header')
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        Catatan Pembayaran: <span class="text-blue-600">{{ $project->nama_proyek }}</span>
    </h2>
@endsection

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-6 flex justify-between items-center">
                <a href="{{ route('pelaksana.projects.pembayaran.create', $project->id) }}"
                    class="inline-flex items-center ...">
                    Catat Pembayaran Baru
                </a>
                <a href="{{ route('pelaksana.projects.index') }}" class="text-sm ...">&larr; Kembali ke Daftar Proyek</a>
            </div>
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-md sm:rounded-lg">
                {{-- ... Kode Tabel untuk menampilkan daftar pembayaran ... --}}
            </div>
        </div>
    </div>
@endsection
