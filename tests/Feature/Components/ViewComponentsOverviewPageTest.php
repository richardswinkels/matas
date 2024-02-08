<?php

namespace Tests\Feature\Components;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ViewComponentsOverviewPageTest extends TestCase
{
    public function test_anyone_can_view_components_overview_page(): void
    {
        $this->get('/components')
            ->assertStatus(200)
            ->assertViewIs('components.index');
    }
}
