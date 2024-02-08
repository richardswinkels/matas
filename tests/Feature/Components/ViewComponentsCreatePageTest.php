<?php

namespace Tests\Feature\Components;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ViewComponentsCreatePageTest extends TestCase
{
    public function test_admin_can_view_component_create_page()
    {
        $this->actingAs(User::factory()->create([
            'is_admin' => true
        ]))
            ->get('/components/create')
            ->assertStatus(200)
            ->assertViewIs('components.create');
    }

    public function test_user_cannot_view_component_create_page()
    {
        $this->actingAs(User::factory()->create([
            'is_admin' => false,
        ]))
            ->get('/components/create')
            ->assertStatus(401);
    }

    public function test_guest_cannot_view_component_create_page()
    {
        $this->get('/components/create')
            ->assertStatus(401);
    }
}
