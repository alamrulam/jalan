<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Membuat Akun Admin
        // Pastikan tidak ada duplikat email sebelum membuat
        User::firstOrCreate(
            ['email' => 'admin@example.com'], // Kondisi untuk mencari
            [
                'name' => 'Admin Proyek',
                'password' => Hash::make('password'), // Ganti 'password' jika perlu
                'role' => 'admin',
            ]
        );

        //(Opsional) Anda juga bisa menambahkan pembuatan akun pelaksana di sini
        User::firstOrCreate(
            ['email' => 'pelaksana1@example.com'],
            [ 'name' => 'Pelaksana Lapangan 1',
                'password' => Hash::make('password'),
                'role' => 'pelaksana',
            ]
        );
    }
}
