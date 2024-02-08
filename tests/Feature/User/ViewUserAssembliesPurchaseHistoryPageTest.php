<?php

namespace Tests\Feature\User;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ViewUserAssembliesPurchaseHistoryPageTest extends TestCase
{
    public function test_anyone_can_view_user_purchase_history_page(): void
    {
        $this->actingAs(User::factory()->create())
            ->get("/user")
            ->assertStatus(200)
            ->assertViewIs('users.show');
    }
}
