<?php

namespace App\Http\Controllers\Api\Product;

use App\Services\Product\ProductService;
use Illuminate\Http\JsonResponse;
use Spatie\RouteAttributes\Attributes\Delete;

class DeleteProductController
{
    #[Delete('/products/{id}')]
    public function __invoke(int $id, ProductService $service): JsonResponse
    {
        $product = $service->findOrFail($id);
        $service->delete($product);

        return response()->json(['message' => 'Product deleted successfully']);
    }
}
