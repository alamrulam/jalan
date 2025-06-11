@extends('layouts.admin_app')
@section('title', 'Manajemen Pengguna')
@section('header') <h2 class="font-semibold ...">{{ __('Manajemen Pengguna') }}</h2> @endsection
@section('content')
    <div class="mb-6"><a href="{{ route('admin.users.create') }}" class="inline-flex ...">Tambah Pelaksana Baru</a></div>
    <div class="overflow-x-auto bg-white rounded-lg shadow-md">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-100">
                <tr>
                    <th ...>Nama</th>
                    <th ...>Email</th>
                    <th ...>Role</th>
                    <th ...>Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($users as $user)
                    <tr>
                        <td ...>{{ $user->name }}</td>
                        <td ...>{{ $user->email }}</td>
                        <td ...><span class="px-2 ... bg-green-100 text-green-800">{{ $user->role }}</span></td>
                        <td ...>
                            <a href="{{ route('admin.users.edit', $user->id) }}" class="text-indigo-600 ...">Edit</a>
                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="inline-block"
                                onsubmit="...">@csrf @method('DELETE')<button type="submit"
                                    class="text-red-600 ...">Hapus</button></form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center ...">Tidak ada data pelaksana.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-6">{{ $users->links() }}</div>
@endsection
