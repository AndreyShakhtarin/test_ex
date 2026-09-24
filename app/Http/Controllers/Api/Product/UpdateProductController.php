<?php

namespace App\Http\Controllers\Api\Product;

use App\Data\Product\UpdateProductData;
use App\Services\Product\GetProductService;
use App\Services\Product\UpdateProductService;
use Illuminate\Http\JsonResponse;
use Spatie\RouteAttributes\Attributes\Put;

class UpdateProductController
{
    #[Put('/products/{id}')]
    public function __invoke(int $id, UpdateProductData $data, GetProductService $find, UpdateProductService $update): JsonResponse
    {
        return response()->json($update->handle($find->handle($id), $data));
    }
}
