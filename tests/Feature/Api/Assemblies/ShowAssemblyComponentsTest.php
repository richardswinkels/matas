<?php

namespace Api\Assemblies;

use App\Models\Assembly;
use App\Models\User;
use Illuminate\Http\Response;
use Tests\TestCase;

class ShowAssemblyComponentsTest extends TestCase
{
    public function test_admin_can_get_assembly_components(): void
    {
        $assembly = Assembly::factory()->create();

        $this->actingAs(User::factory()->create([
            'is_admin' => true
        ]))
            ->get("/api/assemblies/{$assembly->id}/components")
            ->assertStatus(Response::HTTP_OK);
    }

    public function test_user_cannot_get_assembly_components(): void
    {
        $assembly = Assembly::factory()->create();

        $this->actingAs(User::factory()->create())
            ->get("/api/assemblies/{$assembly->id}/components")
            ->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    public function test_guest_cannot_get_assembly_components(): void
    {
        $assembly = Assembly::factory()->create();

        $this->get("/api/assemblies/{$assembly->id}/components")
            ->assertStatus(Response::HTTP_UNAUTHORIZED);
    }
}
