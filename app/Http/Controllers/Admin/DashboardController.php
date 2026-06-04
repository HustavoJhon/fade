<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Barber;
use App\Models\Customer;
use App\Models\Income;
use App\Models\Service;
use Carbon\Carbon;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $today = Carbon::today();
        $startOfMonth = Carbon::now()->startOfMonth();

        $dailyRevenue = Income::whereDate('recorded_at', $today)->sum('amount');
        $monthlyRevenue = Income::where('recorded_at', '>=', $startOfMonth)->sum('amount');
        $dailyAppointments = Appointment::whereDate('start_time', $today)->count();
        $monthlyAppointments = Appointment::where('start_time', '>=', $startOfMonth)->count();
        $newCustomers = Customer::where('created_at', '>=', $startOfMonth)->count();
        $topServices = Service::withCount(['appointments' => fn($q) => $q->where('start_time', '>=', $startOfMonth)])
            ->orderByDesc('appointments_count')
            ->take(5)
            ->get();
        $topBarber = Barber::withCount(['appointments' => fn($q) => $q->where('start_time', '>=', $startOfMonth)])
            ->orderByDesc('appointments_count')
            ->first();
        $recentAppointments = Appointment::with(['customer.user', 'barber.user', 'service'])
            ->latest()
            ->take(10)
            ->get();

        $revenueChart = collect(range(29, 0))->map(function ($day) {
            $date = Carbon::today()->subDays($day);
            return [
                'date' => $date->format('Y-m-d'),
                'revenue' => Income::whereDate('recorded_at', $date)->sum('amount'),
            ];
        });

        $servicesChart = Service::where('is_active', true)
            ->withCount('appointments')
            ->get()
            ->map(fn($s) => ['name' => $s->name, 'count' => $s->appointments_count]);

        return view('admin.dashboard', compact(
            'dailyRevenue', 'monthlyRevenue', 'dailyAppointments', 'monthlyAppointments',
            'newCustomers', 'topServices', 'topBarber', 'recentAppointments',
            'revenueChart', 'servicesChart'
        ));
    }
}
