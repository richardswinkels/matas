<?php

namespace Api\Assemblies;

use App\Models\Assembly;
use App\Models\Component;
use App\Models\User;
use Illuminate\Http\Response;
use Tests\TestCase;

class StoreAssemblyComponentTest extends TestCase
{
    public function test_admin_can_add_components_to_assembly(): void
    {
        $assembly = Assembly::factory()->create();
        $component = Component::factory()->create();

        $this->actingAs(User::factory()->create([
            'is_admin' => true,
        ]))
            ->post("/api/assemblies/{$assembly->id}/components/{$component->id}")
            ->assertStatus(Response::HTTP_OK)
            ->assertJson([
                'message' => 'Component successfully added',
            ]);

        $this->assertDatabaseHas('assembly_components', [
            'assembly_id' => $assembly->id,
            'component_id' => $component->id,
        ]);
    }

    public function test_user_cannot_add_components_to_assembly(): void
    {
        $assembly = Assembly::factory()->create();
        $component = Component::factory()->create();

        $this->actingAs(User::factory()->create())
            ->post("/api/assemblies/{$assembly->id}/components/{$component->id}")
            ->assertStatus(Response::HTTP_UNAUTHORIZED);

        $this->assertDatabaseMissing('assembly_components', [
            'assembly_id' => $assembly->id,
            'component_id' => $component->id,
        ]);
    }

    public function test_guest_cannot_add_components_to_assembly(): void
    {
        $assembly = Assembly::factory()->create();
        $component = Component::factory()->create();

        $this->post("/api/assemblies/{$assembly->id}/components/{$component->id}")
            ->assertStatus(Response::HTTP_UNAUTHORIZED);

        $this->assertDatabaseMissing('assembly_components', [
            'assembly_id' => $assembly->id,
            'component_id' => $component->id,
        ]);
    }
}
