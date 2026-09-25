<?php

namespace App\Services\Category;

use App\Events\EntityViewed;
use App\Models\Category;
use App\Repositories\Contracts\CategoryRepositoryInterface;

class GetCategoryService
{
    public function __construct(
        private readonly CategoryRepositoryInterface $repository,
    ) {}

    public function handle(int $id): Category
    {
        $category = $this->repository->findById($id);

        abort_if($category === null, 404, 'Category not found');

        event(new EntityViewed('category', $id));

        return $category;
    }
}
