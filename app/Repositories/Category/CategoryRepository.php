<?php

namespace App\Repositories\Category;

use App\Models\Category;
use App\Repositories\Category\CategoryRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class CategoryRepository
{
    public function paginate(int $perPage = 15): LengthAwarePaginator
    {
        return Category::withCount('products')->latest()->paginate($perPage);
    }

    public function findById(int $id): ?Category
    {
        return Category::withCount('products')->find($id);
    }

    public function create(array $data): Category
    {
        return Category::create($data);
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
