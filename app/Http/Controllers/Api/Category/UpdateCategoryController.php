<?php

namespace App\Http\Controllers\Api\Category;

use App\Data\Category\UpdateCategoryData;
use App\Services\Category\GetCategoryService;
use App\Services\Category\UpdateCategoryService;
use Illuminate\Http\JsonResponse;
use Spatie\RouteAttributes\Attributes\Put;

class UpdateCategoryController
{
    #[Put('/categories/{id}')]
    /**
     * Обновить категорию.
     * Принимает любые из полей: name (string), slug (string), description (string), is_active (bool).
     * Возвращает обновлённую категорию. Отправляет событие entity.updated в WebSocket-канал entities.
     *
     * @LRDparam id integer ID категории
     * @LRDresponses 200|404|422
     */
    public function __invoke(int $id, UpdateCategoryData $data, GetCategoryService $find, UpdateCategoryService $update): JsonResponse
    {
        return response()->json($update->handle($find->handle($id), $data));
    }
}
