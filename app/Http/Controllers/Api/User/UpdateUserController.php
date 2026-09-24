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
    public function __invoke(int $id, UpdateUserData $data, GetUserService $find, UpdateUserService $update): JsonResponse
    {
        return response()->json($update->handle($find->handle($id), $data));
    }
}
