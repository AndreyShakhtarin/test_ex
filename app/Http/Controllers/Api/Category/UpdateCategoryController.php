<?php

namespace App\Http\Controllers\Api\Category;

use App\Data\Category\UpdateCategoryData;
use App\Services\Category\CategoryService;
use Illuminate\Http\JsonResponse;
use Spatie\RouteAttributes\Attributes\Put;

#[Put('/categories/{id}')]
class UpdateCategoryController
{
    public function __invoke(int $id, UpdateCategoryData $data, CategoryService $service): JsonResponse
    {
        $category = $service->findOrFail($id);
        $updated = $service->update($category, $data);

        return response()->json($updated);
    }
}
