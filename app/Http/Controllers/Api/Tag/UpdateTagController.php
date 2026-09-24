<?php

namespace App\Http\Controllers\Api\Tag;

use App\Data\Tag\UpdateTagData;
use App\Services\Tag\GetTagService;
use App\Services\Tag\UpdateTagService;
use Illuminate\Http\JsonResponse;
use Spatie\RouteAttributes\Attributes\Put;

class UpdateTagController
{
    #[Put('/tags/{id}')]
    public function __invoke(int $id, UpdateTagData $data, GetTagService $find, UpdateTagService $update): JsonResponse
    {
        return response()->json($update->handle($find->handle($id), $data));
    }
}
