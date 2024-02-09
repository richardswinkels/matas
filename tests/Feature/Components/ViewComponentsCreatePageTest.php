<?php

namespace Tests\Feature\Components;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class ViewComponentsCreatePageTest extends TestCase
{
    public function test_admin_can_view_component_create_page(): void
    {
        $this->actingAs(User::factory()->create([
            'is_admin' => true
        ]))
            ->get('/components/create')
            ->assertStatus(Response::HTTP_OK)
            ->assertViewIs('components.create');
    }

    public function test_user_cannot_view_component_create_page(): void
    {
        $this->actingAs(User::factory()->create())
            ->get('/components/create')
            ->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    public function test_guest_cannot_view_component_create_page(): void
    {
        $this->get('/components/create')
            ->assertStatus(Response::HTTP_UNAUTHORIZED);
    }
}
