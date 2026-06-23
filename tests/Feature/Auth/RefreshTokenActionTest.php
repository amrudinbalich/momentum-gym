<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\User;
use Tests\TestCase;

class RefreshTokenActionTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_refresh_token(): void
    {
        $user = User::factory()->create([
            'password' => bcrypt('password123'),
        ]);

        // old token
        $oldToken = $user->createToken('mobile-app')->plainTextToken;

        $this->actingAs($user, 'sanctum');

        $response = $this->postJson(route('auth.refresh-token'));

        $response->assertOk()
            ->assertJsonStructure([
                'user',
                'token',
            ]);

        // old tokens should be deleted
        $this->assertDatabaseMissing('personal_access_tokens', [
            'token' => hash('sha256', $oldToken),
        ]);
    }
}
