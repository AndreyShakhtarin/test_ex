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
    /**
     * Обновить продукт.
     * Принимает любые из полей: category_id (int), name (string), slug (string), description (string),
     * price (float, min:0), stock (int, min:0), status (string: active|inactive), tag_ids (array of int).
     * Возвращает обновлённый продукт с категорией и тегами.
     * Отправляет событие entity.updated в WebSocket-канал entities.
     *
     * @LRDparam id integer ID продукта
     * @LRDresponses 200|404|422
     */
    public function __invoke(int $id, UpdateProductData $data, GetProductService $find, UpdateProductService $update): JsonResponse
    {
        return response()->json($update->handle($find->handle($id), $data));
    }
}
