<?php

namespace App\Http\Controllers\Api\Category;

use App\Services\Category\GetCategoryService;
use Illuminate\Http\JsonResponse;
use Spatie\RouteAttributes\Attributes\Get;

class GetCategoryController
{
    #[Get('/categories/{id}')]
    /**
     * Получить категорию по ID.
     * Возвращает категорию с количеством продуктов (products_count).
     *
     * @LRDparam id integer ID категории
     * @LRDresponses 200|404
     */
    public function __invoke(int $id, GetCategoryService $service): JsonResponse
    {
        return response()->json($service->handle($id));
    }
}
