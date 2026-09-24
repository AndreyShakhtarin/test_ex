<?php

namespace App\Services\Tag;

use App\Repositories\Tag\TagRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class ListTagsService
{
    public function __construct(
        private readonly TagRepository $repository,
    ) {}

    public function handle(int $perPage = 15): LengthAwarePaginator
    {
        return $this->repository->paginate($perPage);
    }
}
