<?php

namespace Database\Seeders;

use App\Models\Appointment;
use App\Models\Customer;
use App\Models\Expense;
use App\Models\Gallery;
use App\Models\Income;
use App\Models\LoyaltyPoint;
use App\Models\Payment;
use App\Models\Review;
use App\Models\Service;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class DemoDataSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('role', 'admin')->first();
        $barbers = \App\Models\Barber::with('user')->get();
        $services = Service::all();

        // Clear demo data for fresh seed (order matters for FK constraints)
        \Illuminate\Support\Facades\DB::statement('SET FOREIGN_KEY_CHECKS=0');
        \App\Models\DateOverride::truncate();
        LoyaltyPoint::truncate();
        Gallery::truncate();
        Expense::truncate();
        Review::truncate();
        Payment::truncate();
        Income::truncate();
        Appointment::truncate();
        \Illuminate\Support\Facades\DB::statement('SET FOREIGN_KEY_CHECKS=1');

        // 1. Ensure at least 80 customers
        $customers = Customer::all();
        if ($customers->count() < 80) {
            $newCount = 80 - $customers->count();
            Customer::factory($newCount)->create();
            $customers = Customer::all();
        }

        // 2. Generate 500 appointments across 3 months back and 4 months forward
        $statuses = ['completed', 'completed', 'completed', 'completed', 'confirmed', 'confirmed', 'pending', 'cancelled', 'no_show'];

        for ($i = 0; $i < 500; $i++) {
                $barber = $barbers->random();
                $service = $services->random();
                $customer = $customers->random();
                $status = $statuses[array_rand($statuses)];

                $dayOffset = rand(-90, 120);
                $startHour = rand(9, 17);
                $startMinute = [0, 15, 30, 45][array_rand([0, 15, 30, 45])];

                $startDate = Carbon::today()->addDays($dayOffset)->setTime($startHour, $startMinute, 0);
                $startDayOfWeek = $startDate->dayOfWeek;

                // Skip Sundays (dayOfWeek = 0) and Mondays (dayOfWeek = 1)... actually 0=Sunday, 6=Saturday
                // Our barbers work Mon-Sat (1-6), but let's allow some flexibility
                if ($startDayOfWeek === 0) {
                    $startDate->addDay();
                }

                $endDate = (clone $startDate)->addMinutes($service->duration);

                $appointment = Appointment::factory()->create([
                    'customer_id' => $customer->id,
                    'barber_id' => $barber->id,
                    'service_id' => $service->id,
                    'user_id' => $customer->user_id,
                    'start_time' => $startDate,
                    'end_time' => $endDate,
                    'status' => $status,
                    'total_price' => $service->price,
                    'notes' => fake()->optional(0.3)->sentence(),
                    'created_by' => fake()->randomElement(['guest', 'registered', 'admin']),
                ]);

                // Payments for completed and confirmed (confirmed means already paid)
                if (in_array($status, ['completed', 'confirmed'])) {
                    $paymentMethod = fake()->randomElement(['cash', 'card', 'transfer']);
                    Payment::create([
                        'appointment_id' => $appointment->id,
                        'amount' => $service->price,
                        'payment_method' => $paymentMethod,
                        'status' => 'paid',
                        'paid_at' => $startDate,
                    ]);

                    // Income record
                    $categories = ['haircut', 'beard', 'shave', 'styling', 'treatment'];
                    Income::create([
                        'appointment_id' => $appointment->id,
                        'description' => $service->name . ' - ' . $customer->user->name,
                        'amount' => $service->price,
                        'category' => $categories[array_rand($categories)],
                        'payment_method' => $paymentMethod,
                        'recorded_by' => $admin->id,
                        'recorded_at' => $startDate,
                    ]);

                    // Reviews for completed
                    if ($status === 'completed' && fake()->boolean(55)) {
                        Review::create([
                            'appointment_id' => $appointment->id,
                            'customer_id' => $customer->id,
                            'barber_id' => $barber->id,
                            'rating' => fake()->numberBetween(3, 5),
                            'comment' => fake()->optional(0.7)->randomElement([
                                'Excelente servicio!',
                                'Muito bom, voltarei!',
                                'O melhor barbeiro da cidade!',
                                'Corte perfeito como sempre.',
                                'Atendimento nota 10!',
                                'Profissional muito talentoso.',
                                'Adorei o resultado!',
                                'Sempre saio satisfeito daqui.',
                                'Recomendo para todos!',
                                'Show de bola!',
                            ]),
                            'is_approved' => true,
                        ]);
                    }
                }

                // Cancelled with reason
                if ($status === 'cancelled') {
                    $appointment->update([
                        'cancellation_reason' => fake()->randomElement([
                            'Imprevisto de última hora',
                            'Mudança de horário',
                            'Cliente não compareceu',
                            'Problema pessoal',
                            'Reagendado',
                        ]),
                    ]);
                }
        }

        $this->command->info('500 appointments created!');

        // 3. Expenses (80 records for past 3 months)
        $expenseDescriptions = [
            'Aluguel do salão' => 'rent',
            'Conta de luz' => 'utilities',
            'Conta de água' => 'utilities',
            'Internet' => 'utilities',
            'Material de limpeza' => 'supplies',
            'Shampoo profissional' => 'supplies',
            'Condicionador' => 'supplies',
            'Pomada modeladora' => 'supplies',
            'Óleo para barba' => 'supplies',
            'Navalhas descartáveis' => 'supplies',
            'Lâminas de barbear' => 'supplies',
            'Toalhas novas' => 'supplies',
            'Capas de corte' => 'supplies',
            'Tesouras profissionais' => 'equipment',
            'Máquina de cortar cabelo' => 'equipment',
            'Secador profissional' => 'equipment',
            'Café para clientes' => 'other',
            'Água para clientes' => 'other',
            'Revistas para sala de espera' => 'other',
            'Manutenção de equipamentos' => 'maintenance',
            'Produtos de barbear' => 'supplies',
            'Uniforme funcionários' => 'other',
            'Marketing digital' => 'marketing',
            'Redes sociais (anúncios)' => 'marketing',
        ];

        $existingExpenses = Expense::count();
        if ($existingExpenses < 80) {
            $needed = 80 - $existingExpenses;
            $descriptions = array_keys($expenseDescriptions);
            for ($i = 0; $i < $needed; $i++) {
                $desc = $descriptions[array_rand($descriptions)];
                $cat = $expenseDescriptions[$desc];
                $amount = match($cat) {
                    'rent' => fake()->randomFloat(2, 1500, 3000),
                    'utilities' => fake()->randomFloat(2, 100, 500),
                    'supplies' => fake()->randomFloat(2, 20, 200),
                    'equipment' => fake()->randomFloat(2, 150, 800),
                    'marketing' => fake()->randomFloat(2, 50, 500),
                    default => fake()->randomFloat(2, 10, 150),
                };

                Expense::create([
                    'description' => $desc,
                    'amount' => $amount,
                    'category' => $cat,
                    'payment_method' => fake()->randomElement(['cash', 'card', 'transfer']),
                    'receipt' => null,
                    'recorded_by' => $admin->id,
                    'recorded_at' => Carbon::today()->subDays(rand(0, 90))->setTime(rand(8, 17), rand(0, 59)),
                ]);
            }
        }

        // 4. Date overrides (some days off, holidays)
        $dateOverrideCount = \App\Models\DateOverride::count();
        if ($dateOverrideCount < 15) {
            $needed = 15 - $dateOverrideCount;
            $reasons = ['Feriado', 'Falta pessoal', 'Manutenção no salão', 'Fechado para evento', 'Folga do barbeiro'];
            for ($i = 0; $i < $needed; $i++) {
                $barber = $barbers->random();
                $futureDay = rand(1, 45);
                $date = Carbon::today()->addDays($futureDay);

                \App\Models\DateOverride::create([
                    'barber_id' => $barber->id,
                    'date' => $date,
                    'start_time' => '00:00:00',
                    'end_time' => '23:59:00',
                    'is_available' => false,
                    'reason' => $reasons[array_rand($reasons)],
                ]);
            }
        }

        // 5. Loyalty points for frequent customers
        $lpCount = LoyaltyPoint::count();
        if ($lpCount < 30) {
            $needed = 30 - $lpCount;
            for ($i = 0; $i < $needed; $i++) {
                $customer = $customers->random();
                $points = rand(10, 100);
                LoyaltyPoint::create([
                    'customer_id' => $customer->id,
                    'points' => $points,
                    'type' => 'earned',
                    'reference_type' => 'App\Models\Appointment',
                    'reference_id' => Appointment::where('customer_id', $customer->id)->inRandomOrder()->first()?->id ?? 1,
                    'expires_at' => Carbon::today()->addMonths(6),
                ]);
            }
        }

        // 6. Gallery images (placeholder)
        $galleryCount = Gallery::count();
        if ($galleryCount < 8) {
            $needed = 8 - $galleryCount;
            $captions = [
                'Corte Fade degradê',
                'Barba desenhada',
                'Hot Towel Shave',
                'Degradê militar',
                'Corte social',
                'Barba cheia modelada',
                'Corte infantil',
                'Finalização com pomada',
            ];
            for ($i = 0; $i < $needed; $i++) {
                Gallery::create([
                    'barber_id' => $barbers->random()->id,
                    'image' => 'gallery/placeholder-' . ($i + 1) . '.jpg',
                    'caption' => $captions[$i] ?? 'Estilo FADE',
                    'sort_order' => $i,
                    'is_active' => true,
                ]);
            }
        }

        $this->command->info('Demo data seeded successfully!');
    }
}
