<?php

namespace Tests\Feature\Components;

use App\Http\Resources\ManufacturerResource;
use App\Models\Component;
use App\Models\Manufacturer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ViewComponentsShowPageTest extends TestCase
{
    public function test_anyone_can_view_components_overview_page(): void
    {
        $manufacturer = Manufacturer::factory()->create();
        $component = Component::factory()->create([
            'manufacturer_id' => $manufacturer->id,
        ]);

        $this->get("/components/{$component->id}")
            ->assertStatus(200)
            ->assertViewIs('components.show');
    }
}
