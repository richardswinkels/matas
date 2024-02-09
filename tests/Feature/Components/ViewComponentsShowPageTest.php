<?php

namespace Tests\Feature\Components;

use App\Http\Resources\ManufacturerResource;
use App\Models\Component;
use App\Models\Manufacturer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class ViewComponentsShowPageTest extends TestCase
{
    public function test_anyone_can_view_components_overview_page(): void
    {
        $component = Component::factory()->create();

        $this->get("/components/{$component->id}")
            ->assertStatus(Response::HTTP_OK)
            ->assertViewIs('components.show');
    }
}
