<?php

namespace App\Http\Controllers\Api\Product;

use App\Data\Product\UpdateProductData;
use App\Services\Product\ProductService;
use Illuminate\Http\JsonResponse;
use Spatie\RouteAttributes\Attributes\Put;

class UpdateProductController
{
    #[Put('/products/{id}')]
    public function __invoke(int $id, UpdateProductData $data, ProductService $service): JsonResponse
    {
        $product = $service->findOrFail($id);
        $updated = $service->update($product, $data);

        return response()->json($updated);
    }
}
