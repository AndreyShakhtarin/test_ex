<?php

namespace App\Http\Controllers\Api\Tag;

use App\Services\Tag\TagService;
use Illuminate\Http\JsonResponse;
use Spatie\RouteAttributes\Attributes\Get;

class GetTagController
{
    #[Get('/tags/{id}')]
    public function __invoke(int $id, TagService $service): JsonResponse
    {
        $tag = $service->findOrFail($id);

        return response()->json($tag);
    }
}
