<?php

namespace App\Http\Controllers\Api\User;

use App\Data\User\CreateUserData;
use App\Services\User\CreateUserService;
use Illuminate\Http\JsonResponse;
use Spatie\RouteAttributes\Attributes\Post;

class CreateUserController
{
    #[Post('/users')]
    /**
     * Создать нового пользователя.
     *
     * @lrd:start
     * Создаёт пользователя. После создания отправляет событие `entity.created` в WebSocket-канал `entities`.
     * @lrd:end
     *
     * @LRDparam name string|required Имя пользователя. Пример: John Doe
     * @LRDparam email string|required Email адрес (уникальный). Пример: john@example.com
     * @LRDparam password string|required Пароль минимум 8 символов. Пример: secret123
     * @LRDresponses 201|422
     */
    public function __invoke(CreateUserData $data, CreateUserService $service): JsonResponse
    {
        return response()->json($service->handle($data), 201);
    }
}
