<?php

namespace App\Services\User;

use App\Events\EntityListed;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class ListUsersService
{
    public function __construct(
        private readonly UserRepositoryInterface $repository,
    ) {}

    public function handle(int $perPage = 15): LengthAwarePaginator
    {
        $result = $this->repository->paginate($perPage);

        event(new EntityListed('user', $result->total()));

        return $result;
    }
}
