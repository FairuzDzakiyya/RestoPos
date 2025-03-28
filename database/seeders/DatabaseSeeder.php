<?php

namespace Database\Seeders;

use App\Models\Kategori;
use App\Models\User;
use App\Models\Menu;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call([
            UserSeeder::class,
            // MenuSeeder::class,
            KategoriSeeder::class,
        ]);

        // Menu::factory()->count(5)->create();

        // Kategori::create([
        //     'nama_kategori' => 'Makanan',
        // ]);

        // Kategori::create([
        //     'nama_kategori' => 'Minuman',
        // ]);
    }
}
