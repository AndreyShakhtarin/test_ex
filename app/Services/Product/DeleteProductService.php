<?php

namespace App\Services\Product;

use App\Events\EntityDeleted;
use App\Models\Product;
use App\Repositories\Contracts\ProductRepositoryInterface;

class DeleteProductService
{
    public function __construct(
        private readonly ProductRepositoryInterface $repository,
    ) {}

    public function handle(Product $product): void
    {
        $this->repository->delete($product);

        event(new EntityDeleted('product', $product->id));
    }
}
