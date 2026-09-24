<?php

namespace App\Http\Controllers\Api\Category;

use App\Services\Category\CategoryService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Spatie\RouteAttributes\Attributes\Get;

#[Get('/categories')]
class GetCategoriesController
{
    public function __invoke(Request $request, CategoryService $service): JsonResponse
    {
        $categories = $service->list((int) $request->get('per_page', 15));

        return response()->json($categories);
    }
}
