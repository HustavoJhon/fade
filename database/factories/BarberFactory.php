<?php

namespace Database\Factories;

use App\Models\Barber;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class BarberFactory extends Factory
{
    protected $model = Barber::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'bio' => fake()->paragraph(),
            'specialties' => fake()->randomElements(
                ['Fade', 'Buzz Cut', 'Beard Trim', 'Hot Towel Shave', 'Hair Styling', 'Kids Cut', 'Line Up'],
                fake()->numberBetween(1, 4)
            ),
            'commission' => fake()->randomFloat(2, 10, 50),
            'is_active' => true,
        ];
    }
}
