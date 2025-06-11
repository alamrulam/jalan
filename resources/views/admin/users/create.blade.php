@extends('layouts.admin_app')
@section('title', 'Tambah Pelaksana Baru')
@section('header') <h2 class="font-semibold ...">{{ __('Tambah Pelaksana Baru') }}</h2> @endsection
@section('content')
    <form method="POST" action="{{ route('admin.users.store') }}" class="space-y-6">
        @csrf
        <div>
            <label for="name" class="...">Nama Lengkap</label>
            <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus ...>
            @error('name')
                <p class="...">{{ $message }}</p>
            @enderror
        </div>
        <div>
            <label for="email" class="...">Alamat Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required ...>
            @error('email')
                <p class="...">{{ $message }}</p>
            @enderror
        </div>
        <div>
            <label for="password" class="...">Password</label>
            <input id="password" type="password" name="password" required ...>
            @error('password')
                <p class="...">{{ $message }}</p>
            @enderror
        </div>
        <div>
            <label for="password_confirmation" class="...">Konfirmasi Password</label>
            <input id="password_confirmation" type="password" name="password_confirmation" required ...>
        </div>
        <div class="flex items-center justify-end ...">
            <a href="{{ route('admin.users.index') }}" class="...">Batal</a>
            <button type="submit" class="...">Simpan Pengguna</button>
        </div>
    </form>
@endsection
