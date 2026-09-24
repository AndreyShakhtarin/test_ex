<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\Tag;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $categories = Category::all();
        $tags = Tag::all();

        $categories->each(function (Category $category) use ($tags) {
            Product::factory(6)->create(['category_id' => $category->id])
                ->each(function (Product $product) use ($tags) {
                    $product->tags()->attach(
                        $tags->random(rand(1, 3))->pluck('id')
                    );
                });
        });
    }
}
