<?php

namespace Database\Factories;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProfileFactory extends Factory
{
    protected $model = Profile::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'bio' => fake()->paragraph(),
            'avatar' => 'https://i.pravatar.cc/200?u=' . fake()->uuid(),
            'phone' => fake()->phoneNumber(),
            'website' => fake()->url(),
        ];
    }
}
