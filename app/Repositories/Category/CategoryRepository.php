<?php

namespace App\Repositories\Category;

use App\Models\Category;
use App\Repositories\Contracts\CategoryRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class CategoryRepository implements CategoryRepositoryInterface
{
    public function count(): int
    {
        return Category::query()->count();
    }

    public function paginate(int $perPage = 15): LengthAwarePaginator
    {
        return Category::query()->withCount('products')->latest()->paginate($perPage);
    }

    public function findById(int $id): ?Category
    {
        return Category::query()->withCount('products')->find($id);
    }

    public function create(array $data): Category
    {
        return Category::query()->create($data);
    }

    public function update(Category $category, array $data): Category
    {
        $category->update($data);

        return $category->fresh();
    }

    public function delete(Category $category): void
    {
        $category->delete();
    }
}
