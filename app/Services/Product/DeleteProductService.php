<?php

namespace App\Services\Product;

use App\Events\EntityDeleted;
use App\Models\Product;
use App\Repositories\Product\ProductRepository;

class DeleteProductService
{
    public function __construct(
        private readonly ProductRepository $repository,
    ) {}

    public function handle(Product $product): void
    {
        $this->repository->delete($product);

        event(new EntityDeleted('product', $product->id));
    }
}
