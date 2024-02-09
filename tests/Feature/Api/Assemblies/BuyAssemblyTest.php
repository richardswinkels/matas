<?php

namespace Api\Assemblies;

use App\Models\Assembly;
use App\Models\User;
use Illuminate\Http\Response;
use Tests\TestCase;

class BuyAssemblyTest extends TestCase
{
    public function test_user_can_buy_assembly(): void
    {
        $user = User::factory()->create();

        $assembly = Assembly::factory()->create([
            'price' => 100,
        ]);

        $this->actingAs($user)
            ->postJson("/api/user/assemblies/{$assembly->id}", [
                'quantity' => 3,
            ])
            ->assertStatus(Response::HTTP_OK)
            ->assertJson([
                'message' => 'Assemblies purchased successfully',
            ]);

        $this->assertDatabaseHas('user_assemblies', [
                'user_id' => $user->id,
                'assembly_id' => $assembly->id,
                'quantity' => 3,
            ]);
    }

    public function test_guest_cannot_buy_assembly(): void
    {
        $assembly = Assembly::factory()->create([
            'price' => 100,
        ]);

        $this->postJson("/api/user/assemblies/{$assembly->id}", [
                'quantity' => 3,
            ])
            ->assertStatus(Response::HTTP_UNAUTHORIZED);
    }
}
