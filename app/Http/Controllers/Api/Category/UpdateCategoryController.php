<?php

namespace App\Http\Controllers\Api\Category;

use App\Data\Category\UpdateCategoryData;
use App\Services\Category\GetCategoryService;
use App\Services\Category\UpdateCategoryService;
use Illuminate\Http\JsonResponse;
use Spatie\RouteAttributes\Attributes\Put;

class UpdateCategoryController
{
    #[Put('/categories/{id}')]
    public function __invoke(int $id, UpdateCategoryData $data, GetCategoryService $find, UpdateCategoryService $update): JsonResponse
    {
        return response()->json($update->handle($find->handle($id), $data));
    }
}
