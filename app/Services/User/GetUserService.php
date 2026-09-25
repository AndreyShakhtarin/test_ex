<?php

namespace App\Services\User;

use App\Events\EntityViewed;
use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;

class GetUserService
{
    public function __construct(
        private readonly UserRepositoryInterface $repository,
    ) {}

    public function handle(int $id): User
    {
        $user = $this->repository->findById($id);

        abort_if($user === null, 404, 'User not found');

        event(new EntityViewed('user', $id));

        return $user;
    }
}
