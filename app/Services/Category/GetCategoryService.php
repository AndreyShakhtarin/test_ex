<?php

namespace App\Services\Category;

use App\Models\Category;
use App\Repositories\Category\CategoryRepository;

class GetCategoryService
{
    public function __construct(
        private readonly CategoryRepository $repository,
    ) {}

    public function handle(int $id): Category
    {
        $category = $this->repository->findById($id);

        abort_if($category === null, 404, 'Category not found');

        return $category;
    }
}
