@extends('layouts.admin_app')
@section('title', 'Tambah Jenis Pekerjaan')
@section('content')
    <form method="POST" action="{{-- route store --}}" class="space-y-6 max-w-lg mx-auto ...">
        @csrf
        {{-- @method('PUT') jika halaman edit --}}
        <div>
            <label for="nama_pekerjaan">Nama Pekerjaan</label>
            <input id="nama_pekerjaan" type="text" name="nama_pekerjaan" value="{{-- old() atau data dari model --}}" required>
        </div>
        <div>
            <label for="deskripsi">Deskripsi (Opsional)</label>
            <textarea id="deskripsi" name="deskripsi" rows="3">{{-- old() atau data dari model --}}</textarea>
        </div>
        <div>
            <label for="progres">Progres (%)</label>
            <select id="progres" name="progres" required>
                <option value="0" {{-- kondisi selected --}}>0%</option>
                <option value="25" {{-- kondisi selected --}}>25%</option>
                <option value="50" {{-- kondisi selected --}}>50%</option>
                <option value="75" {{-- kondisi selected --}}>75%</option>
                <option value="100" {{-- kondisi selected --}}>100%</option>
            </select>
        </div>
        <div class="flex items-center justify-end ...">
            <a href="{{-- route index --}}" class="...">Batal</a>
            <button type="submit" class="ml-3 ...">edit simpan</button>
        </div>
    </form>
@endsection
