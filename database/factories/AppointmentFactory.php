<?php

namespace Database\Factories;

use App\Models\Appointment;
use App\Models\Customer;
use App\Models\Barber;
use App\Models\Service;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class AppointmentFactory extends Factory
{
    protected $model = Appointment::class;

    public function definition(): array
    {
        $start = fake()->dateTimeBetween('-1 month', '+1 month');
        $end = (clone $start)->modify('+' . fake()->randomElement([15, 20, 30, 45, 60]) . ' minutes');

        return [
            'customer_id' => Customer::factory(),
            'barber_id' => Barber::factory(),
            'service_id' => Service::factory(),
            'user_id' => null,
            'start_time' => $start,
            'end_time' => $end,
            'status' => fake()->randomElement(['pending', 'confirmed', 'in_progress', 'completed', 'cancelled', 'no_show']),
            'total_price' => fake()->randomFloat(2, 10, 50),
            'notes' => fake()->optional()->sentence(),
            'cancellation_reason' => null,
            'created_by' => fake()->randomElement(['guest', 'registered', 'admin']),
        ];
    }
}
