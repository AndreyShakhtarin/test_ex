<?php

namespace App\Http\Controllers\Api\Product;

use App\Services\Product\ListProductsService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Spatie\RouteAttributes\Attributes\Get;

class GetProductsController
{
    #[Get('/products')]
    /**
     * Список продуктов с пагинацией.
     * Возвращает продукты с категорией и тегами.
     *
     * @LRDparam per_page integer|optional Количество записей на странице (по умолчанию: 15)
     * @LRDresponses 200
     */
    public function __invoke(Request $request, ListProductsService $service): JsonResponse
    {
        return response()->json($service->handle((int) $request->get('per_page', 15)));
    }
}
