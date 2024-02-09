<?php

namespace Tests\Feature\Components;

use App\Models\Component;
use App\Models\Manufacturer;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class ViewComponentsEditPageTest extends TestCase
{
    public function test_admin_can_view_component_edit_page(): void
    {
        $component = Component::factory()->create();

        $this->actingAs(User::factory()->create([
            'is_admin' => true
        ]))
            ->get("/components/{$component->id}/edit")
            ->assertStatus(Response::HTTP_OK)
            ->assertViewIs('components.edit');
    }

    public function test_user_cannot_view_component_edit_page(): void
    {
        $component = Component::factory()->create();

        $this->actingAs(User::factory()->create())
            ->get("/components/{$component->id}/edit")
            ->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    public function test_guest_cannot_view_component_edit_page(): void
    {
        $component = Component::factory()->create();

        $this->get("/components/{$component->id}/edit")
            ->assertStatus(Response::HTTP_UNAUTHORIZED);
    }
}
