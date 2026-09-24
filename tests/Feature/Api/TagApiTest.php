<?php

namespace Tests\Feature\Api;

use App\Models\Tag;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TagApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_list_tags(): void
    {
        Tag::factory(3)->create();

        $response = $this->getJson('/api/tags');

        $response->assertOk()
            ->assertJsonStructure([
                'data' => [['id', 'name', 'slug', 'color']],
                'total',
            ]);
    }

    public function test_can_create_tag(): void
    {
        $response = $this->postJson('/api/tags', [
            'name' => 'Sale',
            'slug' => 'sale',
            'color' => '#ef4444',
        ]);

        $response->assertCreated()
            ->assertJsonFragment(['slug' => 'sale']);

        $this->assertDatabaseHas('tags', ['slug' => 'sale']);
    }

    public function test_create_tag_validates_required_fields(): void
    {
        $response = $this->postJson('/api/tags', []);

        $response->assertUnprocessable()
            ->assertJsonValidationErrors(['name', 'slug']);
    }

    public function test_create_tag_validates_unique_slug(): void
    {
        Tag::factory()->create(['slug' => 'sale']);

        $response = $this->postJson('/api/tags', [
            'name' => 'Sale 2',
            'slug' => 'sale',
        ]);

        $response->assertUnprocessable()
            ->assertJsonValidationErrors(['slug']);
    }

    public function test_can_get_single_tag(): void
    {
        $tag = Tag::factory()->create();

        $response = $this->getJson('/api/tags/' . $tag->id);

        $response->assertOk()
            ->assertJsonFragment(['id' => $tag->id]);
    }

    public function test_get_tag_returns_404_when_not_found(): void
    {
        $response = $this->getJson('/api/tags/99999');

        $response->assertNotFound();
    }

    public function test_can_update_tag(): void
    {
        $tag = Tag::factory()->create();

        $response = $this->putJson('/api/tags/' . $tag->id, [
            'name' => 'Updated Tag',
            'color' => '#22c55e',
        ]);

        $response->assertOk()
            ->assertJsonFragment(['name' => 'Updated Tag']);
    }

    public function test_can_delete_tag(): void
    {
        $tag = Tag::factory()->create();

        $response = $this->deleteJson('/api/tags/' . $tag->id);

        $response->assertOk();
        $this->assertDatabaseMissing('tags', ['id' => $tag->id]);
    }
}
