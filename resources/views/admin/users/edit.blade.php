@extends('layouts.admin_app')
@section('title', 'Edit Pelaksana')
@section('header') <h2 class="font-semibold ...">{{ __('Edit Pelaksana: ') . $user->name }}</h2> @endsection
@section('content')
    <form method="POST" action="{{ route('admin.users.update', $user->id) }}" class="space-y-6">
        @csrf
        @method('PUT')
        <div>
            <label for="name" class="...">Nama Lengkap</label>
            <input id="name" type="text" name="name" value="{{ old('name', $user->name) }}" required autofocus ...>
            @error('name')
                <p class="...">{{ $message }}</p>
            @enderror
        </div>
        <div>
            <label for="email" class="...">Alamat Email</label>
            <input id="email" type="email" name="email" value="{{ old('email', $user->email) }}" required ...>
            @error('email')
                <p class="...">{{ $message }}</p>
            @enderror
        </div>
        <div class="border-t pt-6 mt-6">
            <p class="text-sm text-gray-500">Kosongkan bagian password jika tidak ingin mengubahnya.</p>
        </div>
        <div>
            <label for="password" class="...">Password Baru</label>
            <input id="password" type="password" name="password" ...>
            @error('password')
                <p class="...">{{ $message }}</p>
            @enderror
        </div>
        <div>
            <label for="password_confirmation" class="...">Konfirmasi Password Baru</label>
            <input id="password_confirmation" type="password" name="password_confirmation" ...>
        </div>
        <div class="flex items-center justify-end ...">
            <a href="{{ route('admin.users.index') }}" class="...">Batal</a>
            <button type="submit" class="...">Update Pengguna</button>
        </div>
    </form>
@endsection
