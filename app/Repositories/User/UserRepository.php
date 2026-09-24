<?php

namespace App\Repositories\User;

use App\Models\User;
use App\Repositories\User\UserRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class UserRepository
{
    public function paginate(int $perPage = 15): LengthAwarePaginator
    {
        return User::with('profile')->latest()->paginate($perPage);
    }

    public function findById(int $id): ?User
    {
        return User::with('profile')->find($id);
    }

    public function create(array $data): User
    {
        return User::create($data);
    }

    public function update(User $user, array $data): User
    {
        $user->update($data);

        return $user->fresh('profile');
    }

    public function delete(User $user): void
    {
        $user->delete();
    }
}
