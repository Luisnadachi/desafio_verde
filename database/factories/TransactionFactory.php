<?php

namespace Database\Factories;

use App\Models\Wallet;
use Illuminate\Database\Eloquent\Factories\Factory;

class TransactionFactory extends Factory
{
    public function definition(): array
    {
        return [
            'amount' => $this->faker->randomFloat(),
            'payer_id' => Wallet::factory(),
            'payee_id' => Wallet::factory(),
        ];
    }
}
