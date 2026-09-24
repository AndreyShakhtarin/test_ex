<?php

namespace App\Http\Controllers\Api\Tag;

use App\Services\Tag\TagService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Spatie\RouteAttributes\Attributes\Get;

#[Get('/tags')]
class GetTagsController
{
    public function __invoke(Request $request, TagService $service): JsonResponse
    {
        $tags = $service->list((int) $request->get('per_page', 15));

        return response()->json($tags);
    }
}
