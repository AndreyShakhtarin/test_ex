<?php

namespace App\Services\Category;

use App\Repositories\Contracts\CategoryRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class ListCategoriesService
{
    public function __construct(
        private readonly CategoryRepositoryInterface $repository,
    ) {}

    public function handle(int $perPage = 15): LengthAwarePaginator
    {
        return $this->repository->paginate($perPage);
    }
}
