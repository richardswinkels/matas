<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'User',
            'email' => 'test@matas.nl',
            'password' => Hash::make('password'),
            'is_admin' => 0,
        ]);

        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@matas.nl',
            'password' => Hash::make('password'),
            'is_admin' => 1,
        ]);
    }
}
