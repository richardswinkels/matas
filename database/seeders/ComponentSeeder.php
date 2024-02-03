<?php

namespace Database\Seeders;

use App\Models\Component;
use App\Models\Manufacturer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ComponentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i < 500; $i++) {
            Component::factory()->create([
                'manufacturer_id' => Manufacturer::inRandomOrder()->first()->id
            ]);
        }
    }
}
