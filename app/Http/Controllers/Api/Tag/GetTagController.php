<?php

namespace App\Http\Controllers\Api\Tag;

use App\Services\Tag\GetTagService;
use Illuminate\Http\JsonResponse;
use Spatie\RouteAttributes\Attributes\Get;

class GetTagController
{
    #[Get('/tags/{id}')]
    /**
     * Получить тег по ID.
     * Возвращает тег с количеством связанных продуктов (products_count).
     *
     * @LRDparam id integer ID тега
     * @LRDresponses 200|404
     */
    public function __invoke(int $id, GetTagService $service): JsonResponse
    {
        return response()->json($service->handle($id));
    }
}
