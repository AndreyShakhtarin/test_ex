<?php

namespace App\Services\User;

use App\Repositories\User\UserRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class ListUsersService
{
    public function __construct(
        private readonly UserRepository $repository,
    ) {}

    public function handle(int $perPage = 15): LengthAwarePaginator
    {
        return $this->repository->paginate($perPage);
    }
}
