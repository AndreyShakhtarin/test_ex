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
     *
     * @lrd:start
     * Все поля опциональны. Возвращает обновлённый продукт с категорией и тегами.
     * Отправляет событие `entity.updated` в WebSocket-канал `entities`.
     * @lrd:end
     *
     * @LRDparam id integer ID продукта. Пример: 1
     * @LRDparam category_id integer|nullable ID категории. Пример: 2
     * @LRDparam name string|nullable Новое название. Пример: iPhone 15 Pro Max
     * @LRDparam slug string|nullable Новый слаг. Пример: iphone-15-pro-max
     * @LRDparam description string|nullable Новое описание. Пример: Обновлённая версия
     * @LRDparam price number|nullable Новая цена. Пример: 1099.99
     * @LRDparam stock integer|nullable Новое количество. Пример: 25
     * @LRDparam status string|nullable Новый статус: active | inactive | out_of_stock. Пример: inactive
     * @LRDparam tag_ids array|nullable Новый массив ID тегов. Пример: [1, 3]
     * @LRDresponses 200|404|422
     */
    public function __invoke(int $id, UpdateProductData $data, GetProductService $find, UpdateProductService $update): JsonResponse
    {
        return response()->json($update->handle($find->handle($id), $data));
    }
}
