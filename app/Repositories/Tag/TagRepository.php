<?php

namespace App\Repositories\Tag;

use App\Models\Tag;
use App\Repositories\Contracts\TagRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class TagRepository implements TagRepositoryInterface
{
    public function paginate(int $perPage = 15): LengthAwarePaginator
    {
        return Tag::query()->withCount('products')->latest()->paginate($perPage);
    }

    public function findById(int $id): ?Tag
    {
        return Tag::query()->withCount('products')->find($id);
    }

    public function create(array $data): Tag
    {
        return Tag::query()->create($data);
    }

    public function update(Tag $tag, array $data): Tag
    {
        $tag->update($data);

        return $tag->fresh();
    }

    public function delete(Tag $tag): void
    {
        $tag->delete();
    }
}
