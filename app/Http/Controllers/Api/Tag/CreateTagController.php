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
     *
     * @lrd:start
     * Отправляет событие `entity.created` в WebSocket-канал `entities`.
     * @lrd:end
     *
     * @LRDparam name string|required Название тега. Пример: Распродажа
     * @LRDparam slug string|required URL-слаг (уникальный). Пример: sale
     * @LRDparam color string|nullable HEX-цвет тега (формат #RRGGBB). Пример: #FF5733
     * @LRDresponses 201|422
     */
    public function __invoke(CreateTagData $data, CreateTagService $service): JsonResponse
    {
        return response()->json($service->handle($data), 201);
    }
}
