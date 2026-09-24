<?php

namespace App\Data\Category;

use Spatie\LaravelData\Attributes\Validation\BooleanType;
use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Attributes\Validation\Nullable;
use Spatie\LaravelData\Attributes\Validation\Sometimes;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;

class UpdateCategoryData extends Data
{
    public function __construct(
        #[Sometimes, Nullable, StringType, Max(255)]
        public readonly string|null|Optional $name,

        #[Sometimes, Nullable, StringType, Max(255)]
        public readonly string|null|Optional $slug,

        #[Sometimes, Nullable, StringType]
        public readonly string|null|Optional $description,

        #[Sometimes, Nullable, BooleanType]
        public readonly bool|null|Optional $is_active,
    ) {}
}
