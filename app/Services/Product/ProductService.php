<?php

namespace App\Services\Product;

use App\Data\Product\CreateProductData;
use App\Data\Product\UpdateProductData;
use App\Events\EntityCreated;
use App\Events\EntityDeleted;
use App\Events\EntityUpdated;
use App\Models\Product;
use App\Repositories\Contracts\ProductRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use Spatie\LaravelData\Optional;

class ProductService
{
    public function __construct(
        private readonly ProductRepositoryInterface $repository,
    ) {}

    public function list(int $perPage = 15): LengthAwarePaginator
    {
        return $this->repository->paginate($perPage);
    }

    public function findOrFail(int $id): Product
    {
        $product = $this->repository->findById($id);

        abort_if($product === null, 404, 'Product not found');

        return $product;
    }

    public function create(CreateProductData $data): Product
    {
        $product = $this->repository->create([
            'category_id' => $data->category_id,
            'name' => $data->name,
            'slug' => $data->slug,
            'description' => $data->description instanceof Optional ? null : $data->description,
            'price' => $data->price,
            'stock' => $data->stock,
            'status' => $data->status->value,
        ]);

        if (!$data->tag_ids instanceof Optional && !empty($data->tag_ids)) {
            $this->repository->syncTags($product, $data->tag_ids);
        }

        event(new EntityCreated('product', $product->load(['category', 'tags'])->toArray()));

        return $product->load(['category', 'tags']);
    }

    public function update(Product $product, UpdateProductData $data): Product
    {
        $payload = [];

        foreach ($data->toArray() as $key => $value) {
            if (!$value instanceof Optional && $value !== null && $key !== 'tag_ids') {
                $payload[$key] = $value instanceof \BackedEnum ? $value->value : $value;
            }
        }

        $updated = $this->repository->update($product, $payload);

        if (!$data->tag_ids instanceof Optional) {
            $this->repository->syncTags($updated, $data->tag_ids ?? []);
        }

        event(new EntityUpdated('product', $updated->load(['category', 'tags'])->toArray()));

        return $updated->load(['category', 'tags']);
    }

    public function delete(Product $product): void
    {
        $this->repository->delete($product);

        event(new EntityDeleted('product', $product->id));
    }
}
