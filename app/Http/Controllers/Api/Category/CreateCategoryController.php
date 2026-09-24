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
     * Принимает: name (string, max:255), slug (string, unique, max:255), description (string, optional), is_active (bool, default:true).
     * Возвращает созданную категорию. Отправляет событие entity.created в WebSocket-канал entities.
     *
     * @LRDresponses 201|422
     */
    public function __invoke(CreateCategoryData $data, CreateCategoryService $service): JsonResponse
    {
        return response()->json($service->handle($data), 201);
    }
}
