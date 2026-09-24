<?php

namespace App\Http\Controllers\Api\Category;

use App\Services\Category\CategoryService;
use Illuminate\Http\JsonResponse;
use Spatie\RouteAttributes\Attributes\Get;

class GetCategoryController
{
    #[Get('/categories/{id}')]
    public function __invoke(int $id, CategoryService $service): JsonResponse
    {
        $category = $service->findOrFail($id);

        return response()->json($category);
    }
}
