<?php

namespace Tests\Feature\Api\Components;

use App\Models\Component;
use App\Models\Manufacturer;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class UpdateComponentTest extends TestCase
{
    /**
     * @dataProvider validComponentDataProvider
     */
    public function test_admin_can_update_component(array $componentData): void
    {
        $component = Component::factory()->create();
        $manufacturer = Manufacturer::factory()->create();

        $componentData = array_merge($componentData, [
           'manufacturer_id' => $manufacturer->id
        ]);

        $this->actingAs(User::factory()->create([
            'is_admin' => true,
        ]))
            ->putJson("/api/components/{$component->id}", $componentData)
            ->assertStatus(Response::HTTP_OK)
            ->assertJson(['message' => 'Component updated successfully']);

        $this->assertDatabaseHas('components', $componentData);
    }

    /**
     * Test admin cannot store component with invalid data.
     *
     * @dataProvider invalidComponentDataProvider
     */
    public function test_admin_cannot_update_component_with_invalid_data(array $componentData): void
    {
        $component = Component::factory()->create();

        $this->actingAs(User::factory()->create(['is_admin' => true]))
            ->putJson("/api/components/{$component->id}", $componentData)
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);

        $this->assertDatabaseMissing('components', $componentData);
    }

    public function test_user_cannot_update_component(): void
    {
        $component = Component::factory()->create();
        $componentData = Component::factory()->make()->toArray();

        $this->actingAs(User::factory()->create())
            ->putJson("/api/components/{$component->id}", $componentData)
            ->assertStatus(Response::HTTP_UNAUTHORIZED);

        $this->assertDatabaseMissing('components', $componentData);
    }

    public function test_guest_cannot_update_component(): void
    {
        $component = Component::factory()->create();
        $componentData = Component::factory()->make()->toArray();

        $this->putJson("/api/components/{$component->id}", $componentData)
            ->assertStatus(Response::HTTP_UNAUTHORIZED);

        $this->assertDatabaseMissing('components', $componentData);
    }

    public static function validComponentDataProvider(): array
    {
        return [
            [['name' => 'Assembly', 'type' => 'test type', 'stock' => 10, 'price' => 100]],
        ];
    }

    public static function invalidComponentDataProvider(): array
    {
        return [
            [['name' => '', 'type' => 'test type', 'manufacturer_id' => 0, 'stock' => 10, 'price' => 100]],
            [['name' => 'Component', 'type' => '', 'manufacturer_id' => 0, 'stock' => 10, 'price' => 100]],
            [['name' => 'Component', 'type' => 'test type', 'manufacturer_id' => 0, 'stock' => -5, 'price' => 100]],
            [['name' => 'Component', 'type' => 'test type', 'manufacturer_id' => 0, 'stock' => '', 'price' => 100]],
            [['name' => 'Component', 'type' => 'test type', 'manufacturer_id' => 0, 'stock' => 5, 'price' => -100]],
            [['name' => 'Component', 'type' => 'test type', 'manufacturer_id' => 0, 'stock' => 5, 'price' => '']],
        ];
    }
}
