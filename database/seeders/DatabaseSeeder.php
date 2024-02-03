<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Manufacturer;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            ManufacturerSeeder::class,
            ComponentSeeder::class,
            AssemblySeeder::class,
            UserSeeder::class,
        ]);
    }
}
