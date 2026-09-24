<?php

namespace App\Http\Controllers\Api\Tag;

use App\Data\Tag\UpdateTagData;
use App\Services\Tag\GetTagService;
use App\Services\Tag\UpdateTagService;
use Illuminate\Http\JsonResponse;
use Spatie\RouteAttributes\Attributes\Put;

class UpdateTagController
{
    #[Put('/tags/{id}')]
    /**
     * Обновить тег.
     *
     * @lrd:start
     * Все поля опциональны. Отправляет событие `entity.updated` в WebSocket-канал `entities`.
     * @lrd:end
     *
     * @LRDparam id integer ID тега. Пример: 1
     * @LRDparam name string|nullable Новое название. Пример: Новинки
     * @LRDparam slug string|nullable Новый слаг. Пример: new-arrivals
     * @LRDparam color string|nullable Новый HEX-цвет. Пример: #33FF57
     * @LRDresponses 200|404|422
     */
    public function __invoke(int $id, UpdateTagData $data, GetTagService $find, UpdateTagService $update): JsonResponse
    {
        return response()->json($update->handle($find->handle($id), $data));
    }
}
