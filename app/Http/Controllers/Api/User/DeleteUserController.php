<?php

namespace App\Http\Controllers\Api\User;

use App\Services\User\DeleteUserService;
use App\Services\User\GetUserService;
use Illuminate\Http\JsonResponse;
use Spatie\RouteAttributes\Attributes\Delete;

class DeleteUserController
{
    #[Delete('/users/{id}')]
    /**
     * Удалить пользователя по ID.
     * Отправляет событие entity.deleted в WebSocket-канал entities.
     *
     * @LRDparam id integer ID пользователя
     * @LRDresponses 200|404
     */
    public function __invoke(int $id, GetUserService $find, DeleteUserService $delete): JsonResponse
    {
        $delete->handle($find->handle($id));

        return response()->json(['message' => 'User deleted successfully']);
    }
}
