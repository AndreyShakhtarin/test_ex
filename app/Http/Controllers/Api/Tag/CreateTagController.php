<?php

namespace App\Http\Controllers\Api\Tag;

use App\Data\Tag\CreateTagData;
use App\Services\Tag\CreateTagService;
use Illuminate\Http\JsonResponse;
use Spatie\RouteAttributes\Attributes\Post;

class CreateTagController
{
    #[Post('/tags')]
    public function __invoke(CreateTagData $data, CreateTagService $service): JsonResponse
    {
        return response()->json($service->handle($data), 201);
    }
}
