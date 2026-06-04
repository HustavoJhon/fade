<?php

namespace Database\Factories;

use App\Models\Schedule;
use App\Models\Barber;
use Illuminate\Database\Eloquent\Factories\Factory;

class ScheduleFactory extends Factory
{
    protected $model = Schedule::class;

    public function definition(): array
    {
        return [
            'barber_id' => Barber::factory(),
            'day_of_week' => fake()->numberBetween(0, 6),
            'start_time' => '09:00:00',
            'end_time' => '18:00:00',
            'is_available' => true,
        ];
    }
}
