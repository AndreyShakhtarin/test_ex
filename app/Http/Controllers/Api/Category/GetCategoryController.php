<?php

namespace App\Http\Controllers\Api\Category;

use App\Services\Category\GetCategoryService;
use Illuminate\Http\JsonResponse;
use Spatie\RouteAttributes\Attributes\Get;

class GetCategoryController
{
    #[Get('/categories/{id}')]
    public function __invoke(int $id, GetCategoryService $service): JsonResponse
    {
        return response()->json($service->handle($id));
    }
}
