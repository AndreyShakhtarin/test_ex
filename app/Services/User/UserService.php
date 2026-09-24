<?php

namespace App\Services\User;

use App\Data\User\CreateUserData;
use App\Data\User\UpdateUserData;
use App\Events\EntityCreated;
use App\Events\EntityDeleted;
use App\Events\EntityUpdated;
use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function __construct(
        private readonly UserRepositoryInterface $repository,
    ) {}

    public function list(int $perPage = 15): LengthAwarePaginator
    {
        return $this->repository->paginate($perPage);
    }

    public function findOrFail(int $id): User
    {
        $user = $this->repository->findById($id);

        abort_if($user === null, 404, 'User not found');

        return $user;
    }

    public function create(CreateUserData $data): User
    {
        $user = $this->repository->create([
            'name' => $data->name,
            'email' => $data->email,
            'password' => Hash::make($data->password),
        ]);

        event(new EntityCreated('user', $user->toArray()));

        return $user;
    }

    public function update(User $user, UpdateUserData $data): User
    {
        $payload = array_filter($data->toArray(), fn ($v) => $v !== null);

        if (isset($payload['password'])) {
            $payload['password'] = Hash::make($payload['password']);
        }

        $updated = $this->repository->update($user, $payload);

        event(new EntityUpdated('user', $updated->toArray()));

        return $updated;
    }

    public function delete(User $user): void
    {
        $this->repository->delete($user);

        event(new EntityDeleted('user', $user->id));
    }
}
