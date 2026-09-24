<?php

namespace Database\Factories;

use App\Enums\Product\ProductStatusEnum;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        $name = fake()->unique()->words(3, true);

        return [
            'category_id' => Category::factory(),
            'name' => ucwords($name),
            'slug' => Str::slug($name) . '-' . fake()->unique()->numberBetween(1, 9999),
            'description' => fake()->paragraphs(2, true),
            'price' => fake()->randomFloat(2, 1, 9999),
            'stock' => fake()->numberBetween(0, 500),
            'status' => fake()->randomElement(ProductStatusEnum::cases())->value,
        ];
    }
}
