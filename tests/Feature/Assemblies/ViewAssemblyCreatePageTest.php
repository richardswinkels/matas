<?php

namespace Tests\Feature\Assemblies;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ViewAssemblyCreatePageTest extends TestCase
{
    public function test_admin_can_view_assembly_create_page()
    {
        $this->actingAs(User::factory()->create([
            'is_admin' => true
        ]))
            ->get('/assemblies/create')
            ->assertStatus(200)
            ->assertViewIs('assemblies.create');
    }

    public function test_user_cannot_view_assembly_create_page()
    {
        $this->actingAs(User::factory()->create([
            'is_admin' => false,
        ]))
            ->get('/assemblies/create')
            ->assertStatus(401);
    }

    public function test_guest_cannot_view_assembly_create_page()
    {
        $this->get('/assemblies/create')
            ->assertStatus(401);
    }
}
