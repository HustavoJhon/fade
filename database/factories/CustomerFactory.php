<?php

namespace Database\Factories;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CustomerFactory extends Factory
{
    protected $model = Customer::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'phone' => fake()->phoneNumber(),
            'birthday' => fake()->optional()->date(),
            'notes' => fake()->optional()->sentence(),
            'total_visits' => fake()->numberBetween(0, 50),
            'total_spent' => fake()->randomFloat(2, 0, 2000),
        ];
    }
}
