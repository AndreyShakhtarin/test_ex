<?php

namespace App\Services\Product;

use App\Data\Product\UpdateProductData;
use App\Events\EntityUpdated;
use App\Models\Product;
use App\Repositories\Contracts\ProductRepositoryInterface;
use Spatie\LaravelData\Optional;

class UpdateProductService
{
    public function __construct(
        private readonly ProductRepositoryInterface $repository,
    ) {}

    public function handle(Product $product, UpdateProductData $data): Product
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
}
