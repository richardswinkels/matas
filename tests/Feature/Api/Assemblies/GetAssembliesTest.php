<?php

namespace Tests\Feature\Api\Assemblies;

use App\Models\Assembly;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GetAssembliesTest extends TestCase
{
    public function test_anyone_can_get_all_assemblies(): void
    {
        Assembly::factory()->createMany(15);
        $this->getJson('/api/assemblies')
            ->assertStatus(200)
            ->assertJsonCount(10, 'data');
    }
}
