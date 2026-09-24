<?php

namespace App\Http\Controllers\Api\Tag;

use App\Data\Tag\UpdateTagData;
use App\Services\Tag\TagService;
use Illuminate\Http\JsonResponse;
use Spatie\RouteAttributes\Attributes\Put;

#[Put('/tags/{id}')]
class UpdateTagController
{
    public function __invoke(int $id, UpdateTagData $data, TagService $service): JsonResponse
    {
        $tag = $service->findOrFail($id);
        $updated = $service->update($tag, $data);

        return response()->json($updated);
    }
}
