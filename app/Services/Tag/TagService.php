<?php

namespace App\Services\Tag;

use App\Data\Tag\CreateTagData;
use App\Data\Tag\UpdateTagData;
use App\Events\EntityCreated;
use App\Events\EntityDeleted;
use App\Events\EntityUpdated;
use App\Models\Tag;
use App\Repositories\Contracts\TagRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class TagService
{
    public function __construct(
        private readonly TagRepositoryInterface $repository,
    ) {}

    public function list(int $perPage = 15): LengthAwarePaginator
    {
        return $this->repository->paginate($perPage);
    }

    public function findOrFail(int $id): Tag
    {
        $tag = $this->repository->findById($id);

        abort_if($tag === null, 404, 'Tag not found');

        return $tag;
    }

    public function create(CreateTagData $data): Tag
    {
        $tag = $this->repository->create($data->toArray());

        event(new EntityCreated('tag', $tag->toArray()));

        return $tag;
    }

    public function update(Tag $tag, UpdateTagData $data): Tag
    {
        $payload = array_filter($data->toArray(), fn ($v) => $v !== null);

        $updated = $this->repository->update($tag, $payload);

        event(new EntityUpdated('tag', $updated->toArray()));

        return $updated;
    }

    public function delete(Tag $tag): void
    {
        $this->repository->delete($tag);

        event(new EntityDeleted('tag', $tag->id));
    }
}
