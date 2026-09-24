<?php

namespace App\Services\Product;

use App\Data\Product\CreateProductData;
use App\Events\EntityCreated;
use App\Models\Product;
use App\Repositories\Product\ProductRepository;
use Spatie\LaravelData\Optional;

class CreateProductService
{
    public function __construct(
        private readonly ProductRepository $repository,
    ) {}

    public function handle(CreateProductData $data): Product
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
}
