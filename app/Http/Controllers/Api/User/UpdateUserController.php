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
     *
     * @lrd:start
     * Все поля опциональны. Отправляет событие `entity.updated` в WebSocket-канал `entities`.
     * @lrd:end
     *
     * @LRDparam id integer ID пользователя. Пример: 1
     * @LRDparam name string|nullable Новое имя. Пример: Jane Doe
     * @LRDparam email string|nullable Новый email. Пример: jane@example.com
     * @LRDparam password string|nullable Новый пароль минимум 8 символов. Пример: newpass123
     * @LRDresponses 200|404|422
     */
    public function __invoke(int $id, UpdateUserData $data, GetUserService $find, UpdateUserService $update): JsonResponse
    {
        return response()->json($update->handle($find->handle($id), $data));
    }
}
