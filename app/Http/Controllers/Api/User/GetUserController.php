<?php

namespace App\Http\Controllers\Api\User;

use App\Services\User\UserService;
use Illuminate\Http\JsonResponse;
use Spatie\RouteAttributes\Attributes\Get;

#[Get('/users/{id}')]
class GetUserController
{
    public function __invoke(int $id, UserService $service): JsonResponse
    {
        $user = $service->findOrFail($id);

        return response()->json($user);
    }
}
