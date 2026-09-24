<?php

namespace App\Http\Controllers\Api\User;

use App\Data\User\UpdateUserData;
use App\Services\User\GetUserService;
use App\Services\User\UpdateUserService;
use Illuminate\Http\JsonResponse;
use Spatie\RouteAttributes\Attributes\Put;

class UpdateUserController
{
    #[Put('/users/{id}')]
    /**
     * Обновить данные пользователя.
     * Принимает любые из полей: name (string), email (string), password (string, min:8).
     * Все поля опциональны. Возвращает обновлённого пользователя с профилем.
     * Отправляет событие entity.updated в WebSocket-канал entities.
     *
     * @LRDparam id integer ID пользователя
     * @LRDresponses 200|404|422
     */
    public function __invoke(int $id, UpdateUserData $data, GetUserService $find, UpdateUserService $update): JsonResponse
    {
        return response()->json($update->handle($find->handle($id), $data));
    }
}
