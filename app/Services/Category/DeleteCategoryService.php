<?php

namespace App\Services\Category;

use App\Events\EntityDeleted;
use App\Models\Category;
use App\Repositories\Contracts\CategoryRepositoryInterface;

class DeleteCategoryService
{
    public function __construct(
        private readonly CategoryRepositoryInterface $repository,
    ) {}

    public function handle(Category $category): void
    {
        $this->repository->delete($category);

        event(new EntityDeleted('category', $category->id));
    }
}
