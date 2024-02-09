<?php

namespace Tests\Feature\Assemblies;

use App\Models\Assembly;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class ViewAssemblyEditPageTest extends TestCase
{
    public function test_admin_can_view_assembly_edit_page(): void
    {
        $assembly = Assembly::factory()->create();

        $this->actingAs(User::factory()->create([
            'is_admin' => true
        ]))
            ->get("/assemblies/{$assembly->id}/edit")
            ->assertStatus(Response::HTTP_OK)
            ->assertViewIs('assemblies.edit');
    }

    public function test_user_cannot_view_assembly_edit_page(): void
    {
        $assembly = Assembly::factory()->create();

        $this->actingAs(User::factory()->create())
            ->get("/assemblies/{$assembly->id}/edit")
            ->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    public function test_guest_cannot_view_assembly_edit_page(): void
    {
        $assembly = Assembly::factory()->create();

        $this->get("/assemblies/{$assembly->id}/edit")
            ->assertStatus(Response::HTTP_UNAUTHORIZED);
    }
}
