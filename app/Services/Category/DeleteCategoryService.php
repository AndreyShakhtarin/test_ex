<?php

namespace App\Services\Category;

use App\Events\EntityDeleted;
use App\Models\Category;
use App\Repositories\Category\CategoryRepository;

class DeleteCategoryService
{
    public function __construct(
        private readonly CategoryRepository $repository,
    ) {}

    public function handle(Category $category): void
    {
        $this->repository->delete($category);

        event(new EntityDeleted('category', $category->id));
    }
}
