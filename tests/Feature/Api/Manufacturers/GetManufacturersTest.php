<?php

namespace Tests\Feature\Api\Manufacturers;

use App\Models\Manufacturer;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class GetManufacturersTest extends TestCase
{
    public function test_admin_can_get_manufacturers(): void
    {
        Manufacturer::factory()->createMany(15);

        $this->actingAs(User::factory()->create([
            'is_admin' => true
        ]))
            ->getJson('/api/manufacturers')
            ->assertJsonCount(15, 'data')
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'name',
                    ],
                ],
            ])
            ->assertStatus(Response::HTTP_OK);
    }

    public function test_user_cannot_get_manufacturers(): void
    {
        $this->actingAs(User::factory()->create())
            ->getJson('/api/manufacturers')
            ->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    public function test_guest_cannot_get_manufacturers(): void
    {
        $this->getJson('/api/manufacturers')
            ->assertStatus(Response::HTTP_UNAUTHORIZED);
    }
}
