<?php

namespace App\Data\Category;

use Spatie\LaravelData\Attributes\Validation\BooleanType;
use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Attributes\Validation\Nullable;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Attributes\Validation\Unique;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;

class CreateCategoryData extends Data
{
    public function __construct(
        #[Required, StringType, Max(255)]
        public readonly string $name,

        #[Required, StringType, Max(255), Unique('categories', 'slug')]
        public readonly string $slug,

        #[Nullable, StringType]
        public readonly string|null|Optional $description,

        #[BooleanType]
        public readonly bool $is_active = true,
    ) {}
}
