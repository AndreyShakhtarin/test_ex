<?php

namespace App\Http\Controllers\Api\Product;

use App\Data\Product\CreateProductData;
use App\Services\Product\CreateProductService;
use Illuminate\Http\JsonResponse;
use Spatie\RouteAttributes\Attributes\Post;

class CreateProductController
{
    #[Post('/products')]
    public function __invoke(CreateProductData $data, CreateProductService $service): JsonResponse
    {
        return response()->json($service->handle($data), 201);
    }
}
