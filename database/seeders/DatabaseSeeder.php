<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Panggil UserSeeder yang telah kita buat
        $this->call([
            UserSeeder::class,
            // Anda bisa menambahkan Seeder lain di sini nanti, misal ProjectSeeder, dll.
        ]);

        // Contoh bawaan Laravel, bisa Anda hapus atau gunakan jika perlu
        // \App\Models\User::factory(10)->create();
        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
