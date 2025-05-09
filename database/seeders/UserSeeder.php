<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = [
            [
                'name' => 'owner',
                'email' => 'owner@gmail.com',
                'role' => 'owner',
                'password' => 'owner',
            ],
            [
                'name' => 'admin',
                'email' => 'admin@gmail.com',
                'role' => 'admin',
                'password' => 'admin123',
            ],
            [
                'name' => 'kasir',
                'email' => 'kasir@gmail.com',
                'role' => 'kasir',
                'password' => 'kasir123',
            ],
            [
                'name' => 'kasir2',
                'email' => 'kasir2@gmail.com',
                'role' => 'kasir',
                'password' => 'kasir123',
            ],
        ];
        foreach ($user as $key => $value) {
            User::create($value);
        }
    }
}
