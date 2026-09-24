<?php

namespace App\Http\Controllers\Api\Category;

use App\Data\Category\CreateCategoryData;
use App\Services\Category\CategoryService;
use Illuminate\Http\JsonResponse;
use Spatie\RouteAttributes\Attributes\Post;

#[Post('/categories')]
class CreateCategoryController
{
    public function __invoke(CreateCategoryData $data, CategoryService $service): JsonResponse
    {
        $category = $service->create($data);

        return response()->json($category, 201);
    }
}
