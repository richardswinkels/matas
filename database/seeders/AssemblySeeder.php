<?php

namespace Database\Seeders;

use App\Models\Assembly;
use App\Models\Component;
use Illuminate\Database\Seeder;

class AssemblySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i < 500; $i++) {
            // Create assembly
            $assembly = Assembly::factory()->create();

            // Get 10 random components
            $components = Component::inRandomOrder()->take(10)->get();

            // Attach components to the assembly
            $assembly->components()->attach($components, [
                'location' => fake()->unique()->text(10),
            ]);
        }
    }
}
