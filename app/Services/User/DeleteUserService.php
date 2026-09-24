<?php

namespace App\Services\User;

use App\Events\EntityDeleted;
use App\Models\User;
use App\Repositories\User\UserRepository;

class DeleteUserService
{
    public function __construct(
        private readonly UserRepository $repository,
    ) {}

    public function handle(User $user): void
    {
        $this->repository->delete($user);

        event(new EntityDeleted('user', $user->id));
    }
}
