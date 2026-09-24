<?php

namespace App\Enums\Product;

enum ProductStatusEnum: string
{
    case Active = 'active';
    case Inactive = 'inactive';
    case OutOfStock = 'out_of_stock';

    public function label(): string
    {
        return match($this) {
            self::Active => 'Active',
            self::Inactive => 'Inactive',
            self::OutOfStock => 'Out of Stock',
        };
    }
}
