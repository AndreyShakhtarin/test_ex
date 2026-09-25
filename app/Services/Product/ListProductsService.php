<?php

namespace App\Services\Product;

use App\Events\EntityListed;
use App\Repositories\Contracts\ProductRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class ListProductsService
{
    public function __construct(
        private readonly ProductRepositoryInterface $repository,
    ) {}

    public function handle(int $perPage = 15): LengthAwarePaginator
    {
        $result = $this->repository->paginate($perPage);

        event(new EntityListed('product', $result->total()));

        return $result;
    }
}
