<?php

namespace App\Services\Product;

use App\Events\EntityViewed;
use App\Models\Product;
use App\Repositories\Contracts\ProductRepositoryInterface;

class GetProductService
{
    public function __construct(
        private readonly ProductRepositoryInterface $repository,
    ) {}

    public function handle(int $id): Product
    {
        $product = $this->repository->findById($id);

        abort_if($product === null, 404, 'Product not found');

        event(new EntityViewed('product', $id));

        return $product;
    }
}
