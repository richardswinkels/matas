<?php

namespace Api\Assemblies;

use App\Models\Assembly;
use App\Models\Component;
use App\Models\User;
use Illuminate\Http\Response;
use Tests\TestCase;

class DestroyAssemblyComponentTest extends TestCase
{
    public function test_admin_can_remove_components_from_assembly(): void
    {
        $assembly = Assembly::factory()->create();
        $component = Component::factory()->create();

        $this->actingAs(User::factory()->create([
            'is_admin' => true,
        ]))
            ->delete("/api/assemblies/{$assembly->id}/components/{$component->id}")
            ->assertStatus(Response::HTTP_OK)
            ->assertJson([
                'message' => 'Component successfully removed',
            ]);

        $this->assertDatabaseMissing('assembly_components', [
            'assembly_id' => $assembly->id,
            'component_id' => $component->id,
        ]);
    }

    public function test_user_cannot_remove_components_from_assembly(): void
    {
        $assembly = Assembly::factory()->create();
        $component = Component::factory()->create();

        $this->actingAs(User::factory()->create())
            ->delete("/api/assemblies/{$assembly->id}/components/{$component->id}")
            ->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    public function test_guest_cannot_remove_components_from_assembly(): void
    {
        $assembly = Assembly::factory()->create();
        $component = Component::factory()->create();

        $this->delete("/api/assemblies/{$assembly->id}/components/{$component->id}")
            ->assertStatus(Response::HTTP_UNAUTHORIZED);
    }
}
