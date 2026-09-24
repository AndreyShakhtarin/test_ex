<?php

namespace App\Services\User;

use App\Data\User\CreateUserData;
use App\Events\EntityCreated;
use App\Models\User;
use App\Repositories\User\UserRepository;
use Illuminate\Support\Facades\Hash;

class CreateUserService
{
    public function __construct(
        private readonly UserRepository $repository,
    ) {}

    public function handle(CreateUserData $data): User
    {
        $user = $this->repository->create([
            'name' => $data->name,
            'email' => $data->email,
            'password' => Hash::make($data->password),
        ]);

        event(new EntityCreated('user', $user->toArray()));

        return $user;
    }
}
