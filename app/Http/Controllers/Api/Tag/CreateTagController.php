<?php

namespace App\Http\Controllers\Api\Tag;

use App\Data\Tag\CreateTagData;
use App\Services\Tag\CreateTagService;
use Illuminate\Http\JsonResponse;
use Spatie\RouteAttributes\Attributes\Post;

class CreateTagController
{
    #[Post('/tags')]
    /**
     * Создать новый тег.
     * Принимает: name (string, max:255), slug (string, unique, max:255), color (string, optional, max:7, например #FF0000).
     * Возвращает созданный тег. Отправляет событие entity.created в WebSocket-канал entities.
     *
     * @LRDresponses 201|422
     */
    public function __invoke(CreateTagData $data, CreateTagService $service): JsonResponse
    {
        return response()->json($service->handle($data), 201);
    }
}
