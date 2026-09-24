<?php

namespace App\Repositories\Product;

use App\Models\Product;
use App\Repositories\Contracts\ProductRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class ProductRepository implements ProductRepositoryInterface
{
    public function paginate(int $perPage = 15): LengthAwarePaginator
    {
        return Product::with(['category', 'tags'])->latest()->paginate($perPage);
    }

    public function findById(int $id): ?Product
    {
        return Product::with(['category', 'tags'])->find($id);
    }

    public function create(array $data): Product
    {
        return Product::create($data);
    }

    public function update(Product $product, array $data): Product
    {
        $product->update($data);

        return $product->fresh(['category', 'tags']);
    }

    public function delete(Product $product): void
    {
        $product->delete();
    }

    public function syncTags(Product $product, array $tagIds): void
    {
        $product->tags()->sync($tagIds);
    }
}
