<?php

namespace App\Services\Tag;

use App\Data\Tag\UpdateTagData;
use App\Events\EntityUpdated;
use App\Models\Tag;
use App\Repositories\Tag\TagRepository;

class UpdateTagService
{
    public function __construct(
        private readonly TagRepository $repository,
    ) {}

    public function handle(Tag $tag, UpdateTagData $data): Tag
    {
        $payload = array_filter($data->toArray(), fn ($v) => $v !== null);

        $updated = $this->repository->update($tag, $payload);

        event(new EntityUpdated('tag', $updated->toArray()));

        return $updated;
    }
}
