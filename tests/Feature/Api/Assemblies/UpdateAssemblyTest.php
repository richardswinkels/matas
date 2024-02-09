<?php

namespace Tests\Feature\Api\Assemblies;

use App\Models\Assembly;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class UpdateAssemblyTest extends TestCase
{
    /**
     * @dataProvider validAssemblyDataProvider
     */
    public function test_admin_can_update_assembly(array $assemblyData): void
    {
        $assembly = Assembly::factory()->create();

        $this->actingAs(User::factory()->create([
            'is_admin' => true
        ]))
            ->putJson("/api/assemblies/{$assembly->id}", $assemblyData)
            ->assertStatus(Response::HTTP_OK)
            ->assertJson(['message' => 'Assembly updated successfully']);

        $this->assertDatabaseHas('assemblies', $assemblyData);
    }

    /**
     * @dataProvider invalidAssemblyDataProvider
     */
    public function test_admin_cannot_update_assembly_with_invalid_data(array $assemblyData)
    {
        $assembly = Assembly::factory()->create();

        $this->actingAs(User::factory()->create([
            'is_admin' => true
        ]))
            ->putJson("/api/assemblies/{$assembly->id}", $assemblyData)
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function test_user_cannot_store_assembly(): void
    {
        $assembly = Assembly::factory()->create();
        $assemblyData = Assembly::factory()->make()->toArray();

        $this->actingAs(User::factory()->create())
            ->putJson("/api/assemblies/{$assembly->id}", $assemblyData)
            ->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    public function test_guest_cannot_store_assembly(): void
    {
        $assembly = Assembly::factory()->create();
        $assemblyData = Assembly::factory()->make()->toArray();

        $this->putJson("/api/assemblies/{$assembly->id}", $assemblyData)
            ->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    public static function validAssemblyDataProvider(): array
    {
        return [
            [['name' => 'Assembly', 'stock' => 10, 'price' => 100]],
        ];
    }

    public static function invalidAssemblyDataProvider(): array
    {
        return [
            [['name' => '', 'stock' => 10, 'price' => 100]],
            [['name' => 'Assembly', 'stock' => -5, 'price' => 100]],
            [['name' => 'Assembly', 'stock' => '', 'price' => 100]],
            [['name' => 'Assembly', 'stock' => 5, 'price' => -100]],
            [['name' => 'Assembly', 'stock' => 5, 'price' => '']],
        ];
    }
}
