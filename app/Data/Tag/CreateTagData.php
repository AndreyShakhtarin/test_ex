<?php

namespace App\Data\Tag;

use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\Unique;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;

class CreateTagData extends Data
{
    public function __construct(
        #[Required, Max(255)]
        public readonly string $name,

        #[Required, Max(255), Unique('tags', 'slug')]
        public readonly string $slug,

        #[Max(7)]
        public readonly string|Optional $color,
    ) {}
}
