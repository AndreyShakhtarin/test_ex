<?php

namespace App\Http\Controllers\Api\User;

use App\Services\User\UserService;
use Illuminate\Http\JsonResponse;
use Spatie\RouteAttributes\Attributes\Delete;

class DeleteUserController
{
    #[Delete('/users/{id}')]
    public function __invoke(int $id, UserService $service): JsonResponse
    {
        $user = $service->findOrFail($id);
        $service->delete($user);

        return response()->json(['message' => 'User deleted successfully']);
    }
}
