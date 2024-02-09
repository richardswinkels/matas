<?php

namespace Tests\Feature\Assemblies;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class ViewAssemblyOverviewPageTest extends TestCase
{
    public function test_anyone_can_view_assembly_overview_page(): void
    {
        $this->get('/assemblies')
            ->assertStatus(Response::HTTP_OK)
            ->assertViewIs('assemblies.index');
    }
}
