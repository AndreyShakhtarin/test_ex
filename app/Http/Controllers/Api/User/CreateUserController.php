<?php

namespace App\Http\Controllers\Api\User;

use App\Data\User\CreateUserData;
use App\Services\User\CreateUserService;
use Illuminate\Http\JsonResponse;
use Spatie\RouteAttributes\Attributes\Post;

class CreateUserController
{
    #[Post('/users')]
    public function __invoke(CreateUserData $data, CreateUserService $service): JsonResponse
    {
        return response()->json($service->handle($data), 201);
    }
}
