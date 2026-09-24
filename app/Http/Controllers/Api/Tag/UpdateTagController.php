<?php

namespace App\Http\Controllers\Api\Tag;

use App\Data\Tag\UpdateTagData;
use App\Services\Tag\TagService;
use Illuminate\Http\JsonResponse;
use Spatie\RouteAttributes\Attributes\Put;

class UpdateTagController
{
    #[Put('/tags/{id}')]
    public function __invoke(int $id, UpdateTagData $data, TagService $service): JsonResponse
    {
        $tag = $service->findOrFail($id);
        $updated = $service->update($tag, $data);

        return response()->json($updated);
    }
}
