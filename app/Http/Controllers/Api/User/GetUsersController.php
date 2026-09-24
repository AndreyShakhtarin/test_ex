<?php

namespace App\Http\Controllers\Api\User;

use App\Services\User\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Spatie\RouteAttributes\Attributes\Get;

class GetUsersController
{
    #[Get('/users')]
    public function __invoke(Request $request, UserService $service): JsonResponse
    {
        $users = $service->list((int) $request->get('per_page', 15));

        return response()->json($users);
    }
}
