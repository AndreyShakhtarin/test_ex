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
     * Принимает: name (string, max:255), email (string, unique), password (string, min:8).
     * Возвращает созданного пользователя. Отправляет событие entity.created в WebSocket-канал entities.
     *
     * @LRDresponses 201|422
     */
    public function __invoke(CreateUserData $data, CreateUserService $service): JsonResponse
    {
        return response()->json($service->handle($data), 201);
    }
}
