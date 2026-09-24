<?php

namespace App\Services\Category;

use App\Data\Category\CreateCategoryData;
use App\Events\EntityCreated;
use App\Models\Category;
use App\Repositories\Contracts\CategoryRepositoryInterface;

class CreateCategoryService
{
    public function __construct(
        private readonly CategoryRepositoryInterface $repository,
    ) {}

    public function handle(CreateCategoryData $data): Category
    {
        $category = $this->repository->create($data->toArray());

        event(new EntityCreated('category', $category->toArray()));

        return $category;
    }
}
