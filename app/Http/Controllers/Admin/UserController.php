<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Menampilkan daftar semua pengguna (khususnya pelaksana).
     */
    public function index()
    {
        // Ambil semua pengguna dengan role 'pelaksana'
        $users = User::where('role', 'pelaksana')->latest()->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    /**
     * Menampilkan form untuk membuat pengguna (pelaksana) baru.
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Menyimpan pengguna baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'pelaksana', // Set role langsung sebagai 'pelaksana'
        ]);

        return redirect()->route('admin.users.index')->with('success', 'Akun pelaksana berhasil dibuat.');
    }

    /**
     * Menampilkan form untuk mengedit pengguna.
     */
    public function edit(User $user)
    {
        // Pastikan tidak bisa mengedit admin lain atau diri sendiri melalui antarmuka ini (jika perlu)
        if ($user->role == 'admin') {
            return redirect()->route('admin.users.index')->with('error', 'Tidak dapat mengedit akun admin.');
        }
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Mengupdate data pengguna.
     */
    public function update(Request $request, User $user)
    {
        if ($user->role == 'admin') {
            return redirect()->route('admin.users.index')->with('error', 'Tidak dapat mengupdate akun admin.');
        }

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],  //Password opsional saat edit
        ]);

        $user->name = $request->name;
        $user->email = $request->email;

        // Hanya update password jika diisi
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('admin.users.index')->with('success', 'Akun pelaksana berhasil diperbarui.');
    }

    /**
     * Menghapus pengguna dari database.
     */
    public function destroy(User $user)
    {
        // Tambahkan proteksi agar admin tidak bisa menghapus admin lain atau diri sendiri
        if ($user->role == 'admin' || $user->id == auth()->id()) {
            return redirect()->route('admin.users.index')->with('error', 'Aksi tidak diizinkan.');
        }

        // Hapus relasi di tabel pivot sebelum menghapus user
        $user->assignedProjects()->detach();
        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'Akun pelaksana berhasil dihapus.');
    }
}
