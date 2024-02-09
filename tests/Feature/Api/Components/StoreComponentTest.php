<?php

namespace Tests\Feature\Api\Components;

use App\Models\Component;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class StoreComponentTest extends TestCase
{
    public function test_admin_can_store_component(): void
    {
        $componentData = Component::factory()->make()->toArray();

        $this->actingAs(User::factory()->create([
            'is_admin' => true,
        ]))
            ->postJson('/api/components', $componentData)
            ->assertStatus(Response::HTTP_CREATED)
            ->assertJson(['message' => 'Component created successfully']);

        $this->assertDatabaseHas('components', $componentData);
    }

    /**
     * Test admin cannot store component with invalid data.
     *
     * @dataProvider invalidComponentDataProvider
     */
    public function test_admin_cannot_store_component_with_invalid_data(array $componentData): void
    {
        $this->actingAs(User::factory()->create(['is_admin' => true]))
            ->postJson('/api/components', $componentData)
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);

        $this->assertDatabaseMissing('components', $componentData);
    }

    public function test_user_cannot_store_component(): void
    {
        $componentData = Component::factory()->make()->toArray();

        $this->actingAs(User::factory()->create())
            ->postJson('/api/components', $componentData)
            ->assertStatus(Response::HTTP_UNAUTHORIZED);

        $this->assertDatabaseMissing('components', $componentData);
    }

    public function test_guest_cannot_store_component(): void
    {
        $componentData = Component::factory()->make()->toArray();

        $this->postJson('/api/components', $componentData)
            ->assertStatus(Response::HTTP_UNAUTHORIZED);

        $this->assertDatabaseMissing('components', $componentData);
    }

    public static function invalidComponentDataProvider(): array
    {
        return [
            [['name' => '', 'manufacturer_id' => 0, 'stock' => 10, 'price' => 100]],
            [['name' => 'Component', 'manufacturer_id' => 0, 'stock' => -5, 'price' => 100]],
            [['name' => 'Component', 'manufacturer_id' => 0, 'stock' => '', 'price' => 100]],
            [['name' => 'Component', 'manufacturer_id' => 0, 'stock' => 5, 'price' => -100]],
            [['name' => 'Component', 'manufacturer_id' => 0, 'stock' => 5, 'price' => '']],
        ];
    }
}
