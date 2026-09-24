<?php

namespace Tests\Unit\Enums;

use App\Enums\Product\ProductStatusEnum;
use PHPUnit\Framework\TestCase;

class ProductStatusEnumTest extends TestCase
{
    public function test_has_correct_values(): void
    {
        $this->assertSame('active', ProductStatusEnum::Active->value);
        $this->assertSame('inactive', ProductStatusEnum::Inactive->value);
        $this->assertSame('out_of_stock', ProductStatusEnum::OutOfStock->value);
    }

    public function test_label_returns_human_readable_string(): void
    {
        $this->assertSame('Active', ProductStatusEnum::Active->label());
        $this->assertSame('Inactive', ProductStatusEnum::Inactive->label());
        $this->assertSame('Out of Stock', ProductStatusEnum::OutOfStock->label());
    }

    public function test_can_be_created_from_value(): void
    {
        $status = ProductStatusEnum::from('active');
        $this->assertSame(ProductStatusEnum::Active, $status);
    }

    public function test_cases_returns_all_enum_values(): void
    {
        $cases = ProductStatusEnum::cases();
        $this->assertCount(3, $cases);
    }
}
