<?php

namespace App\Services\Tag;

use App\Events\EntityViewed;
use App\Models\Tag;
use App\Repositories\Contracts\TagRepositoryInterface;

class GetTagService
{
    public function __construct(
        private readonly TagRepositoryInterface $repository,
    ) {}

    public function handle(int $id): Tag
    {
        $tag = $this->repository->findById($id);

        abort_if($tag === null, 404, 'Tag not found');

        event(new EntityViewed('tag', $id));

        return $tag;
    }
}
