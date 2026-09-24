<?php

namespace App\Data\Product;

use App\Enums\Product\ProductStatusEnum;
use Spatie\LaravelData\Attributes\Validation\ArrayType;
use Spatie\LaravelData\Attributes\Validation\Exists;
use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Attributes\Validation\Min;
use Spatie\LaravelData\Attributes\Validation\Sometimes;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;

class UpdateProductData extends Data
{
    public function __construct(
        #[Sometimes, Exists('categories', 'id')]
        public readonly int|Optional $category_id,

        #[Sometimes, Max(255)]
        public readonly string|Optional $name,

        #[Sometimes, Max(255)]
        public readonly string|Optional $slug,

        public readonly string|Optional $description,

        #[Sometimes, Min(0)]
        public readonly float|Optional $price,

        #[Sometimes, Min(0)]
        public readonly int|Optional $stock,

        public readonly ProductStatusEnum|Optional $status,

        #[Sometimes, ArrayType]
        public readonly array|Optional $tag_ids,
    ) {}
}
