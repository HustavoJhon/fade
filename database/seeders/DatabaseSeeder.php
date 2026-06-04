<?php

namespace Database\Seeders;

use App\Models\Appointment;
use App\Models\Barber;
use App\Models\BusinessSetting;
use App\Models\Customer;
use App\Models\Payment;
use App\Models\Review;
use App\Models\Schedule;
use App\Models\Service;
use App\Models\ServiceCategory;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Admin user
        $admin = User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@barberia.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
            'phone' => '+111111111',
        ]);

        // Barber users and their profiles
        $barberUsers = collect();
        $barberNames = ['Carlos Mendes', 'Rafael Oliveira', 'Diego Santos'];
        foreach ($barberNames as $name) {
            $barberUsers->push(User::factory()->create([
                'name' => $name,
                'role' => 'barber',
            ]));
        }

        $barbers = collect();
        foreach ($barberUsers as $user) {
            $barbers->push(Barber::factory()->create([
                'user_id' => $user->id,
                'specialties' => fake()->randomElements(
                    ['Fade', 'Buzz Cut', 'Beard Trim', 'Hot Towel Shave', 'Hair Styling', 'Kids Cut', 'Line Up'],
                    3
                ),
            ]));
        }

        // Schedules for barbers (Mon-Sat, 9:00-18:00, break 12:30-13:00)
        foreach ($barbers as $barber) {
            for ($day = 1; $day <= 6; $day++) {
                Schedule::factory()->create([
                    'barber_id' => $barber->id,
                    'day_of_week' => $day,
                    'start_time' => '09:00:00',
                    'end_time' => '18:00:00',
                    'is_available' => true,
                ]);
            }
        }

        // Service categories and services
        $categoriesData = [
            'Haircuts' => [
                ['Classic Haircut', 25, 30],
                ['Fade Cut', 30, 45],
                ['Buzz Cut', 20, 20],
                ['Line Up', 15, 15],
            ],
            'Beard & Mustache' => [
                ['Beard Trim', 15, 20],
                ['Beard Sculpting', 20, 30],
                ['Beard Wash & Condition', 10, 15],
            ],
            'Shaving' => [
                ['Hot Towel Shave', 35, 45],
                ['Straight Razor Shave', 40, 60],
            ],
            'Hair Styling' => [
                ['Hair Styling', 25, 30],
                ['Hair Wash & Blow Dry', 20, 25],
                ['Hair Dye', 50, 60],
            ],
            'Kids' => [
                ['Kids Haircut', 20, 20],
                ['Kids Fade', 25, 30],
            ],
        ];

        $categories = collect();
        foreach ($categoriesData as $catName => $services) {
            $category = ServiceCategory::factory()->create([
                'name' => $catName,
                'slug' => str($catName)->slug(),
                'sort_order' => $categories->count(),
            ]);
            $categories->push($category);

            foreach ($services as [$svcName, $price, $duration]) {
                Service::factory()->create([
                    'category_id' => $category->id,
                    'name' => $svcName,
                    'slug' => str($svcName)->slug(),
                    'price' => $price,
                    'duration' => $duration,
                ]);
            }
        }

        // 20 customers
        Customer::factory(20)->create();

        // 50 appointments with mixed statuses
        $customers = Customer::all();
        $services = Service::all();
        $statuses = ['completed', 'completed', 'completed', 'confirmed', 'pending', 'cancelled', 'no_show'];

        for ($i = 0; $i < 50; $i++) {
            $barber = $barbers->random();
            $service = $services->random();
            $customer = $customers->random();
            $status = $statuses[array_rand($statuses)];

            $startHour = rand(9, 16);
            $startMinute = rand(0, 3) * 15;
            $dayOffset = rand(-30, 30);
            $startDate = now()->addDays($dayOffset)->setTime($startHour, $startMinute, 0);
            $endDate = (clone $startDate)->addMinutes($service->duration);

            $appointment = Appointment::factory()->create([
                'customer_id' => $customer->id,
                'barber_id' => $barber->id,
                'service_id' => $service->id,
                'start_time' => $startDate,
                'end_time' => $endDate,
                'status' => $status,
                'total_price' => $service->price,
            ]);

            // Payment for completed appointments
            if ($status === 'completed') {
                Payment::create([
                    'appointment_id' => $appointment->id,
                    'amount' => $service->price,
                    'payment_method' => fake()->randomElement(['cash', 'card', 'transfer']),
                    'status' => 'paid',
                    'paid_at' => $startDate,
                ]);

                // Review for some completed
                if (fake()->boolean(60)) {
                    Review::create([
                        'appointment_id' => $appointment->id,
                        'customer_id' => $customer->id,
                        'barber_id' => $barber->id,
                        'rating' => fake()->numberBetween(3, 5),
                        'comment' => fake()->optional()->sentence(),
                        'is_approved' => true,
                    ]);
                }
            }
        }

        // Business settings
        $settings = [
            'business_name' => 'Fade Barbershop',
            'business_address' => '123 Main Street, Downtown',
            'business_phone' => '+5511999999999',
            'business_email' => 'contact@fadebarbershop.com',
            'opening_hours' => 'Mon-Sat 9:00-18:00',
            'currency' => 'BRL',
            'timezone' => 'America/Sao_Paulo',
            'default_appointment_duration' => '30',
            'cancelation_policy' => 'Free cancellation up to 2 hours before appointment.',
        ];

        foreach ($settings as $key => $value) {
            BusinessSetting::create(['key' => $key, 'value' => $value]);
        }
    }
}
