<?php

namespace App\Http\Controllers\Api\Category;

use App\Data\Category\CreateCategoryData;
use App\Services\Category\CategoryService;
use Illuminate\Http\JsonResponse;
use Spatie\RouteAttributes\Attributes\Post;

class CreateCategoryController
{
    #[Post('/categories')]
    public function __invoke(CreateCategoryData $data, CategoryService $service): JsonResponse
    {
        $category = $service->create($data);

        return response()->json($category, 201);
    }
}
