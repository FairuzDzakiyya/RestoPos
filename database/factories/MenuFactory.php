<?php

namespace Database\Factories;

use App\Models\Kategori;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\menu>
 */
class MenuFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // $data = DB::table('kategoris')->inRandomOrder()->select('id')->first();
        
        return [
            // 'id' => "MNU" .sprintf("%08d", fake()->unique()->numberBetween(1, 99999999)),
            // 'kategori_id' => fake()->randomElement(Kategori::select('id')->get()),
            // 'menu' => fake()->randomElement(['Ayam Goreng', 'Nasi Goreng', 'Mie Goreng', 'Sate Ayam', 'Soto Ayam', 'Bakso', 'Mie Ayam']),
            // 'deskripsi' => fake()->word(),
            // 'harga' => fake()->numberBetween(1000, 1000000),
            // 'stok' => fake()->numberBetween(1, 100),
        ];
    }
}
