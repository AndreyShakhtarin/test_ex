<?php

namespace App\Services\Tag;

use App\Events\EntityDeleted;
use App\Models\Tag;
use App\Repositories\Contracts\TagRepositoryInterface;

class DeleteTagService
{
    public function __construct(
        private readonly TagRepositoryInterface $repository,
    ) {}

    public function handle(Tag $tag): void
    {
        $this->repository->delete($tag);

        event(new EntityDeleted('tag', $tag->id));
    }
}
