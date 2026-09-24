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
     *
     * @lrd:start
     * Все поля опциональны. Отправляет событие `entity.updated` в WebSocket-канал `entities`.
     * @lrd:end
     *
     * @LRDparam id integer ID категории. Пример: 1
     * @LRDparam name string|nullable Новое название. Пример: Смартфоны
     * @LRDparam slug string|nullable Новый слаг. Пример: smartphones
     * @LRDparam description string|nullable Новое описание. Пример: Только смартфоны
     * @LRDparam is_active boolean|nullable Статус активности. Пример: false
     * @LRDresponses 200|404|422
     */
    public function __invoke(int $id, UpdateCategoryData $data, GetCategoryService $find, UpdateCategoryService $update): JsonResponse
    {
        return response()->json($update->handle($find->handle($id), $data));
    }
}
