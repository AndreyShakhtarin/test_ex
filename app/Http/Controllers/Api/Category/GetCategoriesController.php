<?php

namespace App\Http\Controllers\Api\Category;

use App\Services\Category\ListCategoriesService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Spatie\RouteAttributes\Attributes\Get;

class GetCategoriesController
{
    #[Get('/categories')]
    /**
     * Список категорий с пагинацией.
     * Возвращает категории с количеством продуктов (products_count).
     *
     * @LRDparam per_page integer|optional Количество записей на странице (по умолчанию: 15)
     * @LRDresponses 200
     */
    public function __invoke(Request $request, ListCategoriesService $service): JsonResponse
    {
        return response()->json($service->handle((int) $request->get('per_page', 15)));
    }
}
