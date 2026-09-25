<?php

namespace App\Services\Category;

use App\Events\EntityListed;
use App\Repositories\Contracts\CategoryRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class ListCategoriesService
{
    public function __construct(
        private readonly CategoryRepositoryInterface $repository,
    ) {}

    public function handle(int $perPage = 15): LengthAwarePaginator
    {
        $result = $this->repository->paginate($perPage);

        event(new EntityListed('category', $result->total()));

        return $result;
    }
}
