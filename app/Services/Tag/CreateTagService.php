<?php

namespace App\Services\Tag;

use App\Data\Tag\CreateTagData;
use App\Events\EntityCreated;
use App\Models\Tag;
use App\Repositories\Contracts\TagRepositoryInterface;

class CreateTagService
{
    public function __construct(
        private readonly TagRepositoryInterface $repository,
    ) {}

    public function handle(CreateTagData $data): Tag
    {
        $tag = $this->repository->create($data->toArray());

        event(new EntityCreated('tag', $tag->toArray()));

        return $tag;
    }
}
