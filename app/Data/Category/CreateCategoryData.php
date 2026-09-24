<?php

namespace App\Data\Category;

use Spatie\LaravelData\Attributes\Validation\BooleanType;
use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\Unique;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;

class CreateCategoryData extends Data
{
    public function __construct(
        #[Required, Max(255)]
        public readonly string $name,

        #[Required, Max(255), Unique('categories', 'slug')]
        public readonly string $slug,

        public readonly string|Optional $description,

        #[BooleanType]
        public readonly bool $is_active = true,
    ) {}
}
