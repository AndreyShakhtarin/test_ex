<?php

namespace App\Services\User;

use App\Models\User;
use App\Repositories\User\UserRepository;

class GetUserService
{
    public function __construct(
        private readonly UserRepository $repository,
    ) {}

    public function handle(int $id): User
    {
        $user = $this->repository->findById($id);

        abort_if($user === null, 404, 'User not found');

        return $user;
    }
}
