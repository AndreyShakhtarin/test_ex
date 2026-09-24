<?php

namespace App\Http\Controllers\Api\User;

use App\Data\User\UpdateUserData;
use App\Services\User\UserService;
use Illuminate\Http\JsonResponse;
use Spatie\RouteAttributes\Attributes\Put;

class UpdateUserController
{
    #[Put('/users/{id}')]
    public function __invoke(int $id, UpdateUserData $data, UserService $service): JsonResponse
    {
        $user = $service->findOrFail($id);
        $updated = $service->update($user, $data);

        return response()->json($updated);
    }
}
