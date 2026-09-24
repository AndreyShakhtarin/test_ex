<?php

namespace App\Data\Product;

use App\Enums\Product\ProductStatusEnum;
use Spatie\LaravelData\Attributes\Validation\ArrayType;
use Spatie\LaravelData\Attributes\Validation\Exists;
use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Attributes\Validation\Min;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\Unique;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;

class CreateProductData extends Data
{
    public function __construct(
        #[Required, Exists('categories', 'id')]
        public readonly int $category_id,

        #[Required, Max(255)]
        public readonly string $name,

        #[Required, Max(255), Unique('products', 'slug')]
        public readonly string $slug,

        public readonly string|Optional $description,

        #[Required, Min(0)]
        public readonly float $price,

        #[Min(0)]
        public readonly int $stock = 0,

        public readonly ProductStatusEnum $status = ProductStatusEnum::Active,

        #[ArrayType]
        public readonly array|Optional $tag_ids,
    ) {}
}
