<?php

namespace App\Http\Controllers\Api\Product;

use App\Data\Product\CreateProductData;
use App\Services\Product\CreateProductService;
use Illuminate\Http\JsonResponse;
use Spatie\RouteAttributes\Attributes\Post;

class CreateProductController
{
    #[Post('/products')]
    /**
     * Создать новый продукт.
     *
     * @lrd:start
     * Возвращает продукт с категорией и тегами. Отправляет событие `entity.created` в WebSocket-канал `entities`.
     * Статусы: `active`, `inactive`, `out_of_stock`.
     * @lrd:end
     *
     * @LRDparam category_id integer|required ID существующей категории. Пример: 1
     * @LRDparam name string|required Название продукта. Пример: iPhone 15 Pro
     * @LRDparam slug string|required URL-слаг (уникальный). Пример: iphone-15-pro
     * @LRDparam description string|nullable Описание продукта. Пример: Флагманский смартфон Apple
     * @LRDparam price number|required Цена (дробное число, >= 0). Пример: 999.99
     * @LRDparam stock integer Количество на складе (>= 0, по умолчанию 0). Пример: 50
     * @LRDparam status string Статус: active | inactive | out_of_stock (по умолчанию active). Пример: active
     * @LRDparam tag_ids array|nullable Массив ID тегов. Пример: [1, 2, 3]
     * @LRDresponses 201|422
     */
    public function __invoke(CreateProductData $data, CreateProductService $service): JsonResponse
    {
        return response()->json($service->handle($data), 201);
    }
}
