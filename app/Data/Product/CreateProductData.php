<?php

namespace App\Data\Product;

use App\Enums\Product\ProductStatusEnum;
use Spatie\LaravelData\Attributes\Validation\ArrayType;
use Spatie\LaravelData\Attributes\Validation\Exists;
use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Attributes\Validation\Min;
use Spatie\LaravelData\Attributes\Validation\Nullable;
use Spatie\LaravelData\Attributes\Validation\Numeric;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Attributes\Validation\Unique;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;

class CreateProductData extends Data
{
    public function __construct(
        #[Required, IntegerType, Exists('categories', 'id')]
        public readonly int $category_id,

        #[Required, StringType, Max(255)]
        public readonly string $name,

        #[Required, StringType, Max(255), Unique('products', 'slug')]
        public readonly string $slug,

        #[Nullable, StringType]
        public readonly string|null|Optional $description,

        #[Required, Numeric, Min(0)]
        public readonly float $price,

        #[IntegerType, Min(0)]
        public readonly int $stock = 0,

        public readonly ProductStatusEnum $status = ProductStatusEnum::Active,

        #[Nullable, ArrayType]
        public readonly array|null|Optional $tag_ids,
    ) {}
}
