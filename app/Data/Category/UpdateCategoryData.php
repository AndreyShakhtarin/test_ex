<?php

namespace App\Data\Category;

use Spatie\LaravelData\Attributes\Validation\BooleanType;
use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Attributes\Validation\Sometimes;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;

class UpdateCategoryData extends Data
{
    public function __construct(
        #[Sometimes, Max(255)]
        public readonly string|Optional $name,

        #[Sometimes, Max(255)]
        public readonly string|Optional $slug,

        public readonly string|Optional $description,

        #[Sometimes, BooleanType]
        public readonly bool|Optional $is_active,
    ) {}
}
