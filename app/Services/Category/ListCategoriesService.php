<?php

namespace App\Services\Category;

use App\Repositories\Category\CategoryRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class ListCategoriesService
{
    public function __construct(
        private readonly CategoryRepository $repository,
    ) {}

    public function handle(int $perPage = 15): LengthAwarePaginator
    {
        return $this->repository->paginate($perPage);
    }
}
