<?php

namespace Tests\Feature\Assemblies;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class ViewAssemblyCreatePageTest extends TestCase
{
    public function test_admin_can_view_assembly_create_page(): void
    {
        $this->actingAs(User::factory()->create([
            'is_admin' => true
        ]))
            ->get('/assemblies/create')
            ->assertStatus(Response::HTTP_OK)
            ->assertViewIs('assemblies.create');
    }

    public function test_user_cannot_view_assembly_create_page(): void
    {
        $this->actingAs(User::factory()->create())
            ->get('/assemblies/create')
            ->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    public function test_guest_cannot_view_assembly_create_page(): void
    {
        $this->get('/assemblies/create')
            ->assertStatus(Response::HTTP_UNAUTHORIZED);
    }
}
