<?php

namespace Tests\Feature\Api;

use App\Enums\Product\ProductStatusEnum;
use App\Models\Category;
use App\Models\Product;
use App\Models\Tag;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductApiTest extends TestCase
{
    use RefreshDatabase;

    private Category $category;

    protected function setUp(): void
    {
        parent::setUp();
        $this->category = Category::factory()->create();
    }

    public function test_can_list_products(): void
    {
        Product::factory(3)->create(['category_id' => $this->category->id]);

        $response = $this->getJson('/api/products');

        $response->assertOk()
            ->assertJsonStructure([
                'data' => [['id', 'name', 'slug', 'price', 'status']],
                'total',
            ]);
    }

    public function test_can_create_product(): void
    {
        $response = $this->postJson('/api/products', [
            'category_id' => $this->category->id,
            'name' => 'iPhone 15',
            'slug' => 'iphone-15',
            'price' => 999.99,
            'stock' => 50,
            'status' => ProductStatusEnum::Active->value,
        ]);

        $response->assertCreated()
            ->assertJsonFragment(['slug' => 'iphone-15']);

        $this->assertDatabaseHas('products', ['slug' => 'iphone-15']);
    }

    public function test_can_create_product_with_tags(): void
    {
        $tags = Tag::factory(2)->create();

        $response = $this->postJson('/api/products', [
            'category_id' => $this->category->id,
            'name' => 'Tagged Product',
            'slug' => 'tagged-product',
            'price' => 49.99,
            'tag_ids' => $tags->pluck('id')->toArray(),
        ]);

        $response->assertCreated();

        $product = Product::where('slug', 'tagged-product')->first();
        $this->assertCount(2, $product->tags);
    }

    public function test_create_product_validates_required_fields(): void
    {
        $response = $this->postJson('/api/products', []);

        $response->assertUnprocessable()
            ->assertJsonValidationErrors(['category_id', 'name', 'slug', 'price']);
    }

    public function test_create_product_validates_category_exists(): void
    {
        $response = $this->postJson('/api/products', [
            'category_id' => 99999,
            'name' => 'Test',
            'slug' => 'test',
            'price' => 10,
        ]);

        $response->assertUnprocessable()
            ->assertJsonValidationErrors(['category_id']);
    }

    public function test_can_get_single_product(): void
    {
        $product = Product::factory()->create(['category_id' => $this->category->id]);

        $response = $this->getJson('/api/products/' . $product->id);

        $response->assertOk()
            ->assertJsonFragment(['id' => $product->id]);
    }

    public function test_get_product_returns_404_when_not_found(): void
    {
        $response = $this->getJson('/api/products/99999');

        $response->assertNotFound();
    }

    public function test_can_update_product(): void
    {
        $product = Product::factory()->create(['category_id' => $this->category->id]);

        $response = $this->putJson('/api/products/' . $product->id, [
            'name' => 'Updated Product',
            'price' => 199.99,
        ]);

        $response->assertOk()
            ->assertJsonFragment(['name' => 'Updated Product']);
    }

    public function test_can_update_product_tags(): void
    {
        $product = Product::factory()->create(['category_id' => $this->category->id]);
        $tags = Tag::factory(3)->create();

        $response = $this->putJson('/api/products/' . $product->id, [
            'tag_ids' => $tags->pluck('id')->toArray(),
        ]);

        $response->assertOk();
        $this->assertCount(3, $product->fresh()->tags);
    }

    public function test_can_delete_product(): void
    {
        $product = Product::factory()->create(['category_id' => $this->category->id]);

        $response = $this->deleteJson('/api/products/' . $product->id);

        $response->assertOk();
        $this->assertDatabaseMissing('products', ['id' => $product->id]);
    }

    public function test_product_has_category_relationship(): void
    {
        $product = Product::factory()->create(['category_id' => $this->category->id]);

        $response = $this->getJson('/api/products/' . $product->id);

        $response->assertOk()
            ->assertJsonPath('category.id', $this->category->id);
    }
}
