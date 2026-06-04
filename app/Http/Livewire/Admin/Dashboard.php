<?php

namespace App\Http\Livewire\Admin;

use App\Models\Appointment;
use App\Models\Barber;
use App\Models\Customer;
use App\Models\Expense;
use App\Models\Income;
use App\Models\Service;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.admin')]
class Dashboard extends Component
{
    public function render()
    {
        $today = Carbon::today();
        $monthStart = Carbon::now()->startOfMonth();

        $todayRevenue = Income::whereDate('recorded_at', $today)->sum('amount');
        $monthRevenue = Income::where('recorded_at', '>=', $monthStart)->sum('amount');
        $monthGoal = 50000;

        $todayAppointments = Appointment::whereDate('start_time', $today)->count();
        $todayCompleted = Appointment::whereDate('start_time', $today)->where('status', 'completed')->count();
        $monthAppointments = Appointment::where('start_time', '>=', $monthStart)->count();
        $monthCancelled = Appointment::where('start_time', '>=', $monthStart)->where('status', 'cancelled')->count();

        $newCustomers = Customer::where('created_at', '>=', $monthStart)->count();
        $returningCustomers = Customer::whereHas('appointments', function ($q) {
            $q->where('start_time', '>=', Carbon::now()->startOfMonth());
        })->where('total_visits', '>', 1)->count();

        $monthExpenses = Expense::where('recorded_at', '>=', $monthStart)->sum('amount');

        $recentAppointments = Appointment::with(['customer.user', 'barber.user', 'service'])
            ->latest()
            ->take(10)
            ->get();

        $topBarber = Barber::with('user')
            ->withCount(['appointments' => fn($q) => $q->where('start_time', '>=', $monthStart)])
            ->orderByDesc('appointments_count')
            ->first();

        $topBarberAppointments = $topBarber?->appointments_count ?? 0;
        $topBarberRevenue = $topBarber ? Income::whereHas('appointment.barber', fn($q) => $q->where('id', $topBarber->id))
            ->where('recorded_at', '>=', $monthStart)
            ->sum('amount') : 0;

        $revenueChart = collect(range(29, 0))->map(function ($day) {
            $date = Carbon::today()->subDays($day);
            return [
                'date' => $date->format('d/m'),
                'revenue' => (float) Income::whereDate('recorded_at', $date)->sum('amount'),
            ];
        });
        $revenueLabels = $revenueChart->pluck('date');
        $revenueValues = $revenueChart->pluck('revenue');

        $servicesChart = Service::where('is_active', true)
            ->withCount('appointments')
            ->get()
            ->map(fn($s) => ['name' => $s->name, 'count' => $s->appointments_count]);
        $serviceLabels = $servicesChart->pluck('name');
        $serviceValues = $servicesChart->pluck('count');

        $totalBarbers = Barber::where('is_active', true)->count();
        $totalServices = Service::where('is_active', true)->count();
        $totalCustomers = Customer::count();
        $pendingAppointments = Appointment::whereIn('status', ['pending', 'confirmed'])->where('start_time', '>=', now())->count();

        return view('livewire.admin.dashboard', compact(
            'todayRevenue', 'monthRevenue', 'monthGoal', 'monthExpenses',
            'todayAppointments', 'todayCompleted', 'monthAppointments', 'monthCancelled',
            'newCustomers', 'returningCustomers',
            'recentAppointments',
            'topBarber', 'topBarberAppointments', 'topBarberRevenue',
            'revenueLabels', 'revenueValues',
            'serviceLabels', 'serviceValues',
            'totalBarbers', 'totalServices', 'totalCustomers', 'pendingAppointments',
        ));
    }
}
