<?php

namespace App\Http\Controllers\Api\Category;

use App\Services\Category\DeleteCategoryService;
use App\Services\Category\GetCategoryService;
use Illuminate\Http\JsonResponse;
use Spatie\RouteAttributes\Attributes\Delete;

class DeleteCategoryController
{
    #[Delete('/categories/{id}')]
    public function __invoke(int $id, GetCategoryService $find, DeleteCategoryService $delete): JsonResponse
    {
        $delete->handle($find->handle($id));

        return response()->json(['message' => 'Category deleted successfully']);
    }
}
