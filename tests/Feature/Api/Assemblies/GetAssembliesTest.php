<?php

namespace Tests\Feature\Api\Assemblies;

use App\Models\Assembly;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class GetAssembliesTest extends TestCase
{
    public function test_anyone_can_get_paginated_assemblies(): void
    {
        Assembly::factory()->createMany(15);

        $this->getJson('/api/assemblies?page=1')
            ->assertJsonCount(10, 'data')
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'name',
                        'image',
                        'thumbnail',
                        'price',
                        'stock'
                    ]
                ]
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

    public function test_anyone_can_search_and_get_assemblies(): void
    {
        Assembly::factory()->create(['name' => 'TestAssembly']);
        Assembly::factory()->times(10)->create();//Many(10);

        $this->getJson('/api/assemblies?search=TestAssembly')
            ->assertJsonCount(1, 'data')
            ->assertJsonPath('data.0.name', 'TestAssembly')
//            ->assertJsonFragment([
//                'name' => 'TestAssembly'
//            ])
            ->assertStatus(Response::HTTP_OK);
    }
}
