<?php

namespace App\Http\Controllers\Api\Category;

use App\Services\Category\ListCategoriesService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Spatie\RouteAttributes\Attributes\Get;

class GetCategoriesController
{
    #[Get('/categories')]
    public function __invoke(Request $request, ListCategoriesService $service): JsonResponse
    {
        return response()->json($service->handle((int) $request->get('per_page', 15)));
    }
}
