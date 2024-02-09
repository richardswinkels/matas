<?php

namespace Tests\Feature\Assemblies;

use App\Models\Assembly;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class ViewAssemblyShowPageTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_anyone_can_view_assembly_show_page(): void
    {
        $assembly = Assembly::factory()->create();

        $this->get("/assemblies/{$assembly->id}")
            ->assertStatus(Response::HTTP_OK)
            ->assertViewIs('assemblies.show');
    }
}
