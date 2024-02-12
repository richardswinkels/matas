<?php

namespace Tests\Feature\Api\Assemblies;

use App\Models\Assembly;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class StoreAssemblyTest extends TestCase
{
    public function test_admin_can_store_assembly(): void
    {
        $this->actingAs(User::factory()->create([
            'is_admin' => true,
        ]))
            ->postJson('/api/assemblies', [
                'name' => 'SomeName',
                'price' => 100,
                'stock' => 1000,
            ])
            ->assertStatus(Response::HTTP_CREATED)
            ->assertJson(['message' => 'Assembly created successfully']);

        $this->assertDatabaseHas(Assembly::class, [
            'name' => 'SomeName',
            'price' => 100,
            'stock' => 1000,
        ]);
    }

    /**
     * Test admin cannot store assembly with invalid data.
     *
     * @dataProvider invalidAssemblyDataProvider
     */
    public function test_admin_cannot_store_assembly_with_invalid_data(array $assemblyData)
    {
        $this->actingAs(User::factory()->create(['is_admin' => true]))
            ->postJson('/api/assemblies', $assemblyData)
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);

        $this->assertDatabaseMissing('assemblies', $assemblyData);
    }


    public function test_user_cannot_store_assembly(): void
    {
        $assemblyData = Assembly::factory()->make()->toArray();

        $this->actingAs(User::factory()->create())
            ->postJson('/api/assemblies', $assemblyData)
            ->assertStatus(Response::HTTP_UNAUTHORIZED);

        $this->assertDatabaseMissing('assemblies', $assemblyData);
    }

    public function test_guest_cannot_store_assembly(): void
    {
        $assemblyData = Assembly::factory()->make()->toArray();

        $this->postJson('/api/assemblies', $assemblyData)
            ->assertStatus(Response::HTTP_UNAUTHORIZED);

        $this->assertDatabaseMissing('assemblies', $assemblyData);
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
