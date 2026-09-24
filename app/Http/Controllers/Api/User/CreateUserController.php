<?php

namespace App\Http\Controllers\Api\User;

use App\Data\User\CreateUserData;
use App\Services\User\UserService;
use Illuminate\Http\JsonResponse;
use Spatie\RouteAttributes\Attributes\Post;

#[Post('/users')]
class CreateUserController
{
    public function __invoke(CreateUserData $data, UserService $service): JsonResponse
    {
        $user = $service->create($data);

        return response()->json($user, 201);
    }
}
