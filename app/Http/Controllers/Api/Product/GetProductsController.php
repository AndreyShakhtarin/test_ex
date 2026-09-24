<?php

namespace App\Http\Controllers\Api\Product;

use App\Services\Product\ProductService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Spatie\RouteAttributes\Attributes\Get;

#[Get('/products')]
class GetProductsController
{
    public function __invoke(Request $request, ProductService $service): JsonResponse
    {
        $products = $service->list((int) $request->get('per_page', 15));

        return response()->json($products);
    }
}
