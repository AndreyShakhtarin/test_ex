<?php

namespace App\Http\Controllers\Api\Product;

use App\Services\Product\ProductService;
use Illuminate\Http\JsonResponse;
use Spatie\RouteAttributes\Attributes\Get;

class GetProductController
{
    #[Get('/products/{id}')]
    public function __invoke(int $id, ProductService $service): JsonResponse
    {
        $product = $service->findOrFail($id);

        return response()->json($product);
    }
}
