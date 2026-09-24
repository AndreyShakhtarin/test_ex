<?php

namespace App\Http\Controllers\Api\Product;

use App\Data\Product\CreateProductData;
use App\Services\Product\ProductService;
use Illuminate\Http\JsonResponse;
use Spatie\RouteAttributes\Attributes\Post;

class CreateProductController
{
    #[Post('/products')]
    public function __invoke(CreateProductData $data, ProductService $service): JsonResponse
    {
        $product = $service->create($data);

        return response()->json($product, 201);
    }
}
