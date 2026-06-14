<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Ahmad Senara',
            'email' => 'petani@kcs.com',
            'password' => bcrypt('password123'),
            'role' => 'Petani_Hulu',
        ]);

        User::create([
            'name' => 'Siti Kasir',
            'email' => 'kasir@kcs.com',
            'password' => bcrypt('password123'),
            'role' => 'Kasir',
        ]);

        Product::factory()->count(25)->create();
    }
}
