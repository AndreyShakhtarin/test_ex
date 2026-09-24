<?php

namespace App\Http\Controllers\Api\Product;

use App\Services\Product\DeleteProductService;
use App\Services\Product\GetProductService;
use Illuminate\Http\JsonResponse;
use Spatie\RouteAttributes\Attributes\Delete;

class DeleteProductController
{
    #[Delete('/products/{id}')]
    public function __invoke(int $id, GetProductService $find, DeleteProductService $delete): JsonResponse
    {
        $delete->handle($find->handle($id));

        return response()->json(['message' => 'Product deleted successfully']);
    }
}
