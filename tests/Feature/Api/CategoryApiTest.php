<?php

namespace Tests\Feature\Api;

use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoryApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_list_categories(): void
    {
        Category::factory(3)->create();

        $response = $this->getJson('/api/categories');

        $response->assertOk()
            ->assertJsonStructure([
                'data' => [['id', 'name', 'slug']],
                'total',
            ]);
    }

    public function test_can_create_category(): void
    {
        $response = $this->postJson('/api/categories', [
            'name' => 'Electronics',
            'slug' => 'electronics',
            'description' => 'Electronic devices',
            'is_active' => true,
        ]);

        $response->assertCreated()
            ->assertJsonFragment(['slug' => 'electronics']);

        $this->assertDatabaseHas('categories', ['slug' => 'electronics']);
    }

    public function test_create_category_validates_required_fields(): void
    {
        $response = $this->postJson('/api/categories', []);

        $response->assertUnprocessable()
            ->assertJsonValidationErrors(['name', 'slug']);
    }

    public function test_create_category_validates_unique_slug(): void
    {
        Category::factory()->create(['slug' => 'electronics']);

        $response = $this->postJson('/api/categories', [
            'name' => 'Electronics 2',
            'slug' => 'electronics',
        ]);

        $response->assertUnprocessable()
            ->assertJsonValidationErrors(['slug']);
    }

    public function test_can_get_single_category(): void
    {
        $category = Category::factory()->create();

        $response = $this->getJson('/api/categories/' . $category->id);

        $response->assertOk()
            ->assertJsonFragment(['id' => $category->id]);
    }

    public function test_get_category_returns_404_when_not_found(): void
    {
        $response = $this->getJson('/api/categories/99999');

        $response->assertNotFound();
    }

    public function test_can_update_category(): void
    {
        $category = Category::factory()->create();

        $response = $this->putJson('/api/categories/' . $category->id, [
            'name' => 'Updated Name',
        ]);

        $response->assertOk()
            ->assertJsonFragment(['name' => 'Updated Name']);
    }

    public function test_can_delete_category(): void
    {
        $category = Category::factory()->create();

        $response = $this->deleteJson('/api/categories/' . $category->id);

        $response->assertOk();
        $this->assertDatabaseMissing('categories', ['id' => $category->id]);
    }
}
