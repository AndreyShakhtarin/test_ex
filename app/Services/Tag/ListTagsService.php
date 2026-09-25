<?php

namespace App\Services\Tag;

use App\Events\EntityListed;
use App\Repositories\Contracts\TagRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class ListTagsService
{
    public function __construct(
        private readonly TagRepositoryInterface $repository,
    ) {}

    public function handle(int $perPage = 15): LengthAwarePaginator
    {
        $result = $this->repository->paginate($perPage);

        event(new EntityListed('tag', $result->total()));

        return $result;
    }
}
