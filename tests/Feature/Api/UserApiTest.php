<?php

namespace Tests\Feature\Api;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_list_users(): void
    {
        User::factory(3)->create();

        $response = $this->getJson('/api/users');

        $response->assertOk()
            ->assertJsonStructure([
                'data' => [['id', 'name', 'email']],
                'total',
            ]);
    }

    public function test_can_create_user(): void
    {
        $response = $this->postJson('/api/users', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'password123',
        ]);

        $response->assertCreated()
            ->assertJsonFragment(['email' => 'john@example.com']);

        $this->assertDatabaseHas('users', ['email' => 'john@example.com']);
    }

    public function test_create_user_validates_required_fields(): void
    {
        $response = $this->postJson('/api/users', []);

        $response->assertUnprocessable()
            ->assertJsonValidationErrors(['name', 'email', 'password']);
    }

    public function test_create_user_validates_unique_email(): void
    {
        User::factory()->create(['email' => 'taken@example.com']);

        $response = $this->postJson('/api/users', [
            'name' => 'Another User',
            'email' => 'taken@example.com',
            'password' => 'password123',
        ]);

        $response->assertUnprocessable()
            ->assertJsonValidationErrors(['email']);
    }

    public function test_can_get_single_user(): void
    {
        $user = User::factory()->create();

        $response = $this->getJson('/api/users/' . $user->id);

        $response->assertOk()
            ->assertJsonFragment(['id' => $user->id]);
    }

    public function test_get_user_returns_404_when_not_found(): void
    {
        $response = $this->getJson('/api/users/99999');

        $response->assertNotFound();
    }

    public function test_can_update_user(): void
    {
        $user = User::factory()->create();

        $response = $this->putJson('/api/users/' . $user->id, [
            'name' => 'Updated Name',
        ]);

        $response->assertOk()
            ->assertJsonFragment(['name' => 'Updated Name']);

        $this->assertDatabaseHas('users', ['id' => $user->id, 'name' => 'Updated Name']);
    }

    public function test_can_delete_user(): void
    {
        $user = User::factory()->create();

        $response = $this->deleteJson('/api/users/' . $user->id);

        $response->assertOk()
            ->assertJsonFragment(['message' => 'User deleted successfully']);

        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }

    public function test_delete_user_returns_404_when_not_found(): void
    {
        $response = $this->deleteJson('/api/users/99999');

        $response->assertNotFound();
    }
}
