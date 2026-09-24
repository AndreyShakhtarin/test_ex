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
     * Принимает: category_id (int, exists), name (string, max:255), slug (string, unique, max:255),
     * description (string, optional), price (float, min:0), stock (int, min:0, default:0),
     * status (string: active|inactive, default:active), tag_ids (array of int, optional).
     * Возвращает созданный продукт с категорией и тегами.
     * Отправляет событие entity.created в WebSocket-канал entities.
     *
     * @LRDresponses 201|422
     */
    public function __invoke(CreateProductData $data, CreateProductService $service): JsonResponse
    {
        return response()->json($service->handle($data), 201);
    }
}
