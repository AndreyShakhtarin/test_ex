<?php

namespace App\Http\Controllers\Api\Category;

use App\Data\Category\CreateCategoryData;
use App\Services\Category\CreateCategoryService;
use Illuminate\Http\JsonResponse;
use Spatie\RouteAttributes\Attributes\Post;

class CreateCategoryController
{
    #[Post('/categories')]
    /**
     * Создать новую категорию.
     *
     * @lrd:start
     * Отправляет событие `entity.created` в WebSocket-канал `entities`.
     * @lrd:end
     *
     * @LRDparam name string|required Название категории. Пример: Электроника
     * @LRDparam slug string|required URL-слаг (уникальный). Пример: electronics
     * @LRDparam description string|nullable Описание категории. Пример: Смартфоны, планшеты и аксессуары
     * @LRDparam is_active boolean По умолчанию true. Пример: true
     * @LRDresponses 201|422
     */
    public function __invoke(CreateCategoryData $data, CreateCategoryService $service): JsonResponse
    {
        return response()->json($service->handle($data), 201);
    }
}
