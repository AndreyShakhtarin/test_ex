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
use Spatie\LaravelData\Attributes\Validation\Sometimes;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;

class UpdateProductData extends Data
{
    public function __construct(
        #[Sometimes, Nullable, IntegerType, Exists('categories', 'id')]
        public readonly int|null|Optional $category_id,

        #[Sometimes, Nullable, StringType, Max(255)]
        public readonly string|null|Optional $name,

        #[Sometimes, Nullable, StringType, Max(255)]
        public readonly string|null|Optional $slug,

        #[Sometimes, Nullable, StringType]
        public readonly string|null|Optional $description,

        #[Sometimes, Nullable, Numeric, Min(0)]
        public readonly float|null|Optional $price,

        #[Sometimes, Nullable, IntegerType, Min(0)]
        public readonly int|null|Optional $stock,

        #[Sometimes, Nullable]
        public readonly ProductStatusEnum|null|Optional $status,

        #[Sometimes, Nullable, ArrayType]
        public readonly array|null|Optional $tag_ids,
    ) {}
}
