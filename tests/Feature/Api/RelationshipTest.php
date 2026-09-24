<?php

namespace Tests\Feature\Api;

use App\Models\Category;
use App\Models\Product;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RelationshipTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_has_one_profile(): void
    {
        $user = User::factory()->create();
        $user->profile()->create([
            'bio' => 'Test bio',
            'phone' => '+1234567890',
        ]);

        $response = $this->getJson('/api/users/' . $user->id);

        $response->assertOk()
            ->assertJsonPath('profile.bio', 'Test bio');
    }

    public function test_category_has_many_products(): void
    {
        $category = Category::factory()->create();
        Product::factory(3)->create(['category_id' => $category->id]);

        $response = $this->getJson('/api/categories/' . $category->id);

        $response->assertOk();

        $this->assertSame(3, $category->products()->count());
    }

    public function test_product_belongs_to_category(): void
    {
        $category = Category::factory()->create(['name' => 'Electronics']);
        $product = Product::factory()->create(['category_id' => $category->id]);

        $response = $this->getJson('/api/products/' . $product->id);

        $response->assertOk()
            ->assertJsonPath('category.name', 'Electronics');
    }

    public function test_product_belongs_to_many_tags(): void
    {
        $category = Category::factory()->create();
        $product = Product::factory()->create(['category_id' => $category->id]);
        $tags = Tag::factory(3)->create();

        $product->tags()->attach($tags->pluck('id'));

        $response = $this->getJson('/api/products/' . $product->id);

        $response->assertOk();
        $this->assertCount(3, $response->json('tags'));
    }

    public function test_tag_belongs_to_many_products(): void
    {
        $category = Category::factory()->create();
        $tag = Tag::factory()->create();
        $products = Product::factory(2)->create(['category_id' => $category->id]);

        $products->each(fn ($p) => $p->tags()->attach($tag->id));

        $this->assertCount(2, $tag->products()->get());
    }

    public function test_deleting_category_cascades_to_products(): void
    {
        $category = Category::factory()->create();
        $product = Product::factory()->create(['category_id' => $category->id]);

        $this->deleteJson('/api/categories/' . $category->id);

        $this->assertDatabaseMissing('products', ['id' => $product->id]);
    }
}
