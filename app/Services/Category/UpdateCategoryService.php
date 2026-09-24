<?php

namespace App\Services\Category;

use App\Data\Category\UpdateCategoryData;
use App\Events\EntityUpdated;
use App\Models\Category;
use App\Repositories\Contracts\CategoryRepositoryInterface;

class UpdateCategoryService
{
    public function __construct(
        private readonly CategoryRepositoryInterface $repository,
    ) {}

    public function handle(Category $category, UpdateCategoryData $data): Category
    {
        $payload = array_filter($data->toArray(), fn ($v) => $v !== null);

        $updated = $this->repository->update($category, $payload);

        event(new EntityUpdated('category', $updated->toArray()));

        return $updated;
    }
}
