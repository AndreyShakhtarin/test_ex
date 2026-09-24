<?php

namespace App\Http\Controllers\Api\Tag;

use App\Services\Tag\DeleteTagService;
use App\Services\Tag\GetTagService;
use Illuminate\Http\JsonResponse;
use Spatie\RouteAttributes\Attributes\Delete;

class DeleteTagController
{
    #[Delete('/tags/{id}')]
    /**
     * Удалить тег по ID.
     * Отправляет событие entity.deleted в WebSocket-канал entities.
     *
     * @LRDparam id integer ID тега
     * @LRDresponses 200|404
     */
    public function __invoke(int $id, GetTagService $find, DeleteTagService $delete): JsonResponse
    {
        $delete->handle($find->handle($id));

        return response()->json(['message' => 'Tag deleted successfully']);
    }
}
