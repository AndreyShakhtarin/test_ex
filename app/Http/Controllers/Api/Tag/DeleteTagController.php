<?php

namespace App\Http\Controllers\Api\Tag;

use App\Services\Tag\TagService;
use Illuminate\Http\JsonResponse;
use Spatie\RouteAttributes\Attributes\Delete;

#[Delete('/tags/{id}')]
class DeleteTagController
{
    public function __invoke(int $id, TagService $service): JsonResponse
    {
        $tag = $service->findOrFail($id);
        $service->delete($tag);

        return response()->json(['message' => 'Tag deleted successfully']);
    }
}
