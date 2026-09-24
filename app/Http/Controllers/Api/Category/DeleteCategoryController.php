<?php

namespace App\Http\Controllers\Api\Category;

use App\Services\Category\CategoryService;
use Illuminate\Http\JsonResponse;
use Spatie\RouteAttributes\Attributes\Delete;

class DeleteCategoryController
{
    #[Delete('/categories/{id}')]
    public function __invoke(int $id, CategoryService $service): JsonResponse
    {
        $category = $service->findOrFail($id);
        $service->delete($category);

        return response()->json(['message' => 'Category deleted successfully']);
    }
}
