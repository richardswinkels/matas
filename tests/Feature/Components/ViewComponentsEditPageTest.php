<?php

namespace Tests\Feature\Components;

use App\Models\Component;
use App\Models\Manufacturer;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ViewComponentsEditPageTest extends TestCase
{
    public function test_admin_can_view_component_edit_page()
    {
        $manufacturer = Manufacturer::factory()->create();
        $component = Component::factory()->create([
            'manufacturer_id' => $manufacturer->id,
        ]);

        $this->actingAs(User::factory()->create([
            'is_admin' => true
        ]))
            ->get("/components/{$component->id}/edit")
            ->assertStatus(200)
            ->assertViewIs('components.edit');
    }

    public function test_user_cannot_view_component_edit_page()
    {
        $manufacturer = Manufacturer::factory()->create();
        $component = Component::factory()->create([
            'manufacturer_id' => $manufacturer->id,
        ]);

        $this->actingAs(User::factory()->create([
            'is_admin' => false,
        ]))
            ->get("/components/{$component->id}/edit")
            ->assertStatus(401);
    }

    public function test_guest_cannot_view_component_edit_page()
    {
        $manufacturer = Manufacturer::factory()->create();
        $component = Component::factory()->create([
            'manufacturer_id' => $manufacturer->id,
        ]);

        $this->get("/components/{$component->id}/edit")
            ->assertStatus(401);
    }
}
