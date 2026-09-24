<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::factory(10)->create()->each(function (User $user) {
            $user->profile()->create([
                'bio' => fake()->paragraph(),
                'avatar' => 'https://i.pravatar.cc/200?u=' . $user->id,
                'phone' => fake()->phoneNumber(),
                'website' => fake()->url(),
            ]);
        });
    }
}
