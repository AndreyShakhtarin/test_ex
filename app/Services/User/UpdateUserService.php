<?php

namespace App\Services\User;

use App\Data\User\UpdateUserData;
use App\Events\EntityUpdated;
use App\Models\User;
use App\Repositories\User\UserRepository;
use Illuminate\Support\Facades\Hash;

class UpdateUserService
{
    public function __construct(
        private readonly UserRepository $repository,
    ) {}

    public function handle(User $user, UpdateUserData $data): User
    {
        $payload = array_filter($data->toArray(), fn ($v) => $v !== null);

        if (isset($payload['password'])) {
            $payload['password'] = Hash::make($payload['password']);
        }

        $updated = $this->repository->update($user, $payload);

        event(new EntityUpdated('user', $updated->toArray()));

        return $updated;
    }
}
