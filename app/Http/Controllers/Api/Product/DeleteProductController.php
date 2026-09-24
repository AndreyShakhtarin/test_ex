<?php

namespace App\Http\Controllers\Api\Product;

use App\Services\Product\DeleteProductService;
use App\Services\Product\GetProductService;
use Illuminate\Http\JsonResponse;
use Spatie\RouteAttributes\Attributes\Delete;

class DeleteProductController
{
    #[Delete('/products/{id}')]
    /**
     * Удалить продукт по ID.
     * Отправляет событие entity.deleted в WebSocket-канал entities.
     *
     * @LRDparam id integer ID продукта
     * @LRDresponses 200|404
     */
    public function __invoke(int $id, GetProductService $find, DeleteProductService $delete): JsonResponse
    {
        $delete->handle($find->handle($id));

        return response()->json(['message' => 'Product deleted successfully']);
    }
}
