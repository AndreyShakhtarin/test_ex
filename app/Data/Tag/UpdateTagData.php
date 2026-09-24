<?php

namespace App\Data\Tag;

use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Attributes\Validation\Sometimes;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;

class UpdateTagData extends Data
{
    public function __construct(
        #[Sometimes, Max(255)]
        public readonly string|Optional $name,

        #[Sometimes, Max(255)]
        public readonly string|Optional $slug,

        #[Sometimes, Max(7)]
        public readonly string|Optional $color,
    ) {}
}
