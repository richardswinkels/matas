<?php

namespace Tests\Feature\Assemblies;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ViewAssemblyOverviewPageTest extends TestCase
{
    public function test_anyone_can_view_assembly_overview_page(): void
    {
        $this->get('/assemblies')
            ->assertStatus(200)
            ->assertViewIs('assemblies.index');
    }
}
