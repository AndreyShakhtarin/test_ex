<?php

namespace App\Data\Tag;

use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Attributes\Validation\Nullable;
use Spatie\LaravelData\Attributes\Validation\Regex;
use Spatie\LaravelData\Attributes\Validation\Sometimes;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;

class UpdateTagData extends Data
{
    public function __construct(
        #[Sometimes, Nullable, StringType, Max(255)]
        public readonly string|null|Optional $name,

        #[Sometimes, Nullable, StringType, Max(255)]
        public readonly string|null|Optional $slug,

        #[Sometimes, Nullable, StringType, Max(7), Regex('/^#[0-9A-Fa-f]{6}$/')]
        public readonly string|null|Optional $color,
    ) {}
}
