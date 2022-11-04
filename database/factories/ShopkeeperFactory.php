<?php

namespace Database\Factories;

use App\Models\Shopkeeper;
use App\Models\Wallet;
use Illuminate\Database\Eloquent\Factories\Factory;
use Ramsey\Uuid\Uuid;

class ShopkeeperFactory extends Factory
{
    protected $model = Shopkeeper::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'cnpj' => $this->faker->text(),
            'email' => $this->faker->unique()->safeEmail(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'wallet_id' => Wallet::factory(),
        ];
    }
}
