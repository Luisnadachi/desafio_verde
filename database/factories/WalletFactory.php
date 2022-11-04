<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Ramsey\Uuid\Uuid;

class WalletFactory extends Factory
{
    public function definition(): array
    {
        return [
            'balance' => $this->faker->randomFloat(),
            'owner_id' => User::factory(),
        ];
    }
}
