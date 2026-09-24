<?php

namespace App\Http\Controllers\Api\Tag;

use App\Services\Tag\ListTagsService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Spatie\RouteAttributes\Attributes\Get;

class GetTagsController
{
    #[Get('/tags')]
    /**
     * Список тегов с пагинацией.
     * Возвращает теги с количеством продуктов (products_count).
     *
     * @LRDparam per_page integer|optional Количество записей на странице (по умолчанию: 15)
     * @LRDresponses 200
     */
    public function __invoke(Request $request, ListTagsService $service): JsonResponse
    {
        return response()->json($service->handle((int) $request->get('per_page', 15)));
    }
}
