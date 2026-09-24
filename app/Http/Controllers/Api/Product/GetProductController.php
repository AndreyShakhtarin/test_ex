<?php

namespace App\Http\Controllers\Api\Product;

use App\Services\Product\GetProductService;
use Illuminate\Http\JsonResponse;
use Spatie\RouteAttributes\Attributes\Get;

class GetProductController
{
    #[Get('/products/{id}')]
    public function __invoke(int $id, GetProductService $service): JsonResponse
    {
        return response()->json($service->handle($id));
    }
}
