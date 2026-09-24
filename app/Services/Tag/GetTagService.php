<?php

namespace App\Services\Tag;

use App\Models\Tag;
use App\Repositories\Tag\TagRepository;

class GetTagService
{
    public function __construct(
        private readonly TagRepository $repository,
    ) {}

    public function handle(int $id): Tag
    {
        $tag = $this->repository->findById($id);

        abort_if($tag === null, 404, 'Tag not found');

        return $tag;
    }
}
