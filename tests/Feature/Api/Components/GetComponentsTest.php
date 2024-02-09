<?php

namespace Tests\Feature\Api\Components;

use App\Models\Component;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class GetComponentsTest extends TestCase
{
    public function test_anyone_can_get_components(): void
    {
        Component::factory()->createMany(15);

        $this->getJson('/api/components')
            ->assertJsonCount(15, 'data')
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'name',
                        'manufacturer' => [
                            'id',
                            'name',
                        ],
                        'type',
                        'image',
                        'thumbnail',
                        'price',
                        'stock',
                    ],
                ],
            ])
            ->assertStatus(Response::HTTP_OK);
    }

    public function test_anyone_can_get_paginated_components(): void
    {
        Component::factory()->createMany(15);

        $this->getJson('/api/components?page=1')
            ->assertJsonCount(10, 'data')
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'name',
                        'manufacturer' => [
                            'id',
                            'name',
                        ],
                        'type',
                        'image',
                        'thumbnail',
                        'price',
                        'stock',
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

    public function test_anyone_can_search_and_get_components(): void
    {
        Component::factory()->create(['name' => 'TestComponent']);
        Component::factory()->createMany(10);

        $this->getJson('/api/components?search=TestComponent')
            ->assertJsonCount(1, 'data')
            ->assertJsonFragment([
                'name' => 'TestComponent'
            ])
            ->assertStatus(Response::HTTP_OK);
    }
}
