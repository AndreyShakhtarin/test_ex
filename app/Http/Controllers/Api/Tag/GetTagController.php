<?php

namespace App\Http\Controllers\Api\Tag;

use App\Services\Tag\GetTagService;
use Illuminate\Http\JsonResponse;
use Spatie\RouteAttributes\Attributes\Get;

class GetTagController
{
    #[Get('/tags/{id}')]
    public function __invoke(int $id, GetTagService $service): JsonResponse
    {
        return response()->json($service->handle($id));
    }
}
