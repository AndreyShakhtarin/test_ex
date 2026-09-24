<?php

namespace App\Services\Category;

use App\Data\Category\CreateCategoryData;
use App\Data\Category\UpdateCategoryData;
use App\Events\EntityCreated;
use App\Events\EntityDeleted;
use App\Events\EntityUpdated;
use App\Models\Category;
use App\Repositories\Contracts\CategoryRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class CategoryService
{
    public function __construct(
        private readonly CategoryRepositoryInterface $repository,
    ) {}

    public function list(int $perPage = 15): LengthAwarePaginator
    {
        return $this->repository->paginate($perPage);
    }

    public function findOrFail(int $id): Category
    {
        $category = $this->repository->findById($id);

        abort_if($category === null, 404, 'Category not found');

        return $category;
    }

    public function create(CreateCategoryData $data): Category
    {
        $category = $this->repository->create($data->toArray());

        event(new EntityCreated('category', $category->toArray()));

        return $category;
    }

    public function update(Category $category, UpdateCategoryData $data): Category
    {
        $payload = array_filter($data->toArray(), fn ($v) => $v !== null);

        $updated = $this->repository->update($category, $payload);

        event(new EntityUpdated('category', $updated->toArray()));

        return $updated;
    }

    public function delete(Category $category): void
    {
        $this->repository->delete($category);

        event(new EntityDeleted('category', $category->id));
    }
}
