<?php

namespace App\Http\Controllers\Api\Category;

use App\Data\Category\CreateCategoryData;
use App\Services\Category\CreateCategoryService;
use Illuminate\Http\JsonResponse;
use Spatie\RouteAttributes\Attributes\Post;

class CreateCategoryController
{
    #[Post('/categories')]
    public function __invoke(CreateCategoryData $data, CreateCategoryService $service): JsonResponse
    {
        return response()->json($service->handle($data), 201);
    }
}
