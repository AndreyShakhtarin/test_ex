<?php

namespace App\Http\Controllers\Api\User;

use App\Services\User\ListUsersService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Spatie\RouteAttributes\Attributes\Get;

class GetUsersController
{
    #[Get('/users')]
    /**
     * Список пользователей с пагинацией.
     * Возвращает пользователей вместе с профилем.
     *
     * @LRDparam per_page integer|optional Количество записей на странице (по умолчанию: 15)
     * @LRDresponses 200
     */
    public function __invoke(Request $request, ListUsersService $service): JsonResponse
    {
        return response()->json($service->handle((int) $request->get('per_page', 15)));
    }
}
