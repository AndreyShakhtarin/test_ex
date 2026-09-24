<?php

namespace App\Services\Product;

use App\Models\Product;
use App\Repositories\Product\ProductRepository;

class GetProductService
{
    public function __construct(
        private readonly ProductRepository $repository,
    ) {}

    public function handle(int $id): Product
    {
        $product = $this->repository->findById($id);

        abort_if($product === null, 404, 'Product not found');

        return $product;
    }
}
