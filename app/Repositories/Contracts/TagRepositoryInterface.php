<?php

namespace App\Repositories\Contracts;

use App\Models\Tag;
use Illuminate\Pagination\LengthAwarePaginator;

interface TagRepositoryInterface
{
    public function count(): int;

    public function paginate(int $perPage = 15): LengthAwarePaginator;

    public function findById(int $id): ?Tag;

    public function create(array $data): Tag;

    public function update(Tag $tag, array $data): Tag;

    public function delete(Tag $tag): void;
}
