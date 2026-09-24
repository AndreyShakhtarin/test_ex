<?php

namespace App\Http\Controllers\Api\Tag;

use App\Data\Tag\CreateTagData;
use App\Services\Tag\TagService;
use Illuminate\Http\JsonResponse;
use Spatie\RouteAttributes\Attributes\Post;

class CreateTagController
{
    #[Post('/tags')]
    public function __invoke(CreateTagData $data, TagService $service): JsonResponse
    {
        $tag = $service->create($data);

        return response()->json($tag, 201);
    }
}
