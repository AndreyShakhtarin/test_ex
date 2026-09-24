<?php

namespace App\Http\Controllers\Api\User;

use App\Services\User\GetUserService;
use Illuminate\Http\JsonResponse;
use Spatie\RouteAttributes\Attributes\Get;

class GetUserController
{
    #[Get('/users/{id}')]
    /**
     * Получить пользователя по ID.
     * Возвращает данные пользователя вместе с профилем.
     *
     * @LRDparam id integer ID пользователя
     * @LRDresponses 200|404
     */
    public function __invoke(int $id, GetUserService $service): JsonResponse
    {
        return response()->json($service->handle($id));
    }
}
