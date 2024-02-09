<?php

namespace Api\User;

use App\Models\Assembly;
use App\Models\User;
use Illuminate\Http\Response;
use Tests\TestCase;

class GetUserAssembliesTest extends TestCase
{
    public function test_user_can_get_paginated_user_assemblies(): void
    {
        $user = User::factory()->create();
        $user->assemblies()->attach(Assembly::factory()->createMany(15), ['quantity' => 1]);

        $this->actingAs($user)
            ->getJson('/api/user/assemblies')
            ->assertJsonCount(10, 'data')
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'assembly' => [
                            'id',
                            'name',
                            'image',
                            'thumbnail',
                            'price',
                            'stock'
                        ],
                        'quantity',
                        'created_at',
                        'updated_at',
                    ],
                ],
            ])
            ->assertJson([
                'meta' => [
                    'total' => 15,
                    'per_page' => 10,
                    'current_page' => 1,
                    'last_page' => 2,
                    'from' => 1,
                    'to' => 10,
                ],
            ])
            ->assertStatus(Response::HTTP_OK);
    }
}
