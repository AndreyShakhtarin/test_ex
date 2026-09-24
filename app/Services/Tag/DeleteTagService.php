<?php

namespace App\Services\Tag;

use App\Events\EntityDeleted;
use App\Models\Tag;
use App\Repositories\Tag\TagRepository;

class DeleteTagService
{
    public function __construct(
        private readonly TagRepository $repository,
    ) {}

    public function handle(Tag $tag): void
    {
        $this->repository->delete($tag);

        event(new EntityDeleted('tag', $tag->id));
    }
}
