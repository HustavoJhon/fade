<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Livewire\AppointmentBooking;
use App\Http\Livewire\Admin\Dashboard;
use App\Http\Livewire\Admin\Calendar;
use App\Http\Livewire\Admin\AppointmentManager;
use App\Http\Livewire\Admin\BarberManager;
use App\Http\Livewire\Admin\ServiceManager;
use App\Http\Livewire\Admin\CustomerManager;
use App\Http\Livewire\Admin\FinanceManager;
use App\Http\Livewire\Admin\Reports;
use App\Http\Livewire\Admin\Settings;
use App\Http\Livewire\Admin\GalleryManager;
use App\Http\Livewire\Admin\CouponManager;

Route::get('/', [PublicController::class, 'index'])->name('home');
Route::get('/servicios', [PublicController::class, 'services'])->name('services');
Route::get('/nosotros', [PublicController::class, 'about'])->name('about');
Route::get('/contacto', [PublicController::class, 'contact'])->name('contact');
Route::post('/contacto', [ContactController::class, 'submit'])->name('contact.submit');
Route::get('/horarios', [PublicController::class, 'hours'])->name('hours');
Route::get('/galeria', [PublicController::class, 'gallery'])->name('gallery');

Route::get('/reservar', AppointmentBooking::class)->name('booking');
Route::get('/reservar/{barber?}/{service?}', AppointmentBooking::class)->name('booking.with');

Route::middleware('guest')->group(function () {
    Route::get('/login', function () { return view('auth.login'); })->name('login');
    Route::post('/login', function (\Illuminate\Http\Request $request) {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (\Illuminate\Support\Facades\Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            $user = \Illuminate\Support\Facades\Auth::user();
            return redirect()->intended(match($user->role) {
                'admin' => route('admin.dashboard'),
                'barber' => route('barber.dashboard'),
                default => route('customer.dashboard'),
            });
        }

        return back()->withErrors(['email' => 'Credenciales incorrectas.'])->onlyInput('email');
    });
    Route::get('/register', [\App\Http\Controllers\Auth\RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [\App\Http\Controllers\Auth\RegisterController::class, 'register']);
});

Route::middleware(['auth'])->prefix('customer')->name('customer.')->group(function () {
    Route::get('/dashboard', function () {
        $user = auth()->user();
        $upcomingAppointments = \App\Models\Appointment::with(['service', 'barber.user'])
            ->where('user_id', $user->id)
            ->whereIn('status', ['pending', 'confirmed'])
            ->where('start_time', '>=', now())
            ->orderBy('start_time')
            ->get();
        $recentAppointments = \App\Models\Appointment::with(['service', 'barber.user'])
            ->where('user_id', $user->id)
            ->whereIn('status', ['completed', 'cancelled', 'no_show'])
            ->latest()
            ->take(5)
            ->get();
        $completedCount = \App\Models\Appointment::where('user_id', $user->id)->where('status', 'completed')->count();
        $totalAppointments = \App\Models\Appointment::where('user_id', $user->id)->count();
        return view('customer.dashboard', compact('upcomingAppointments', 'recentAppointments', 'completedCount', 'totalAppointments'));
    })->name('dashboard');
    Route::get('/appointments', function () {
        $user = auth()->user();
        $upcomingAppointments = \App\Models\Appointment::with(['service', 'barber.user'])
            ->where('user_id', $user->id)
            ->whereIn('status', ['pending', 'confirmed'])
            ->where('start_time', '>=', now())
            ->orderBy('start_time')
            ->get();
        $historyAppointments = \App\Models\Appointment::with(['service', 'barber.user'])
            ->where('user_id', $user->id)
            ->whereIn('status', ['completed', 'cancelled', 'no_show'])
            ->latest()
            ->paginate(10);
        return view('customer.appointments', compact('upcomingAppointments', 'historyAppointments'));
    })->name('appointments');
    Route::get('/profile', function () { return view('customer.profile'); })->name('profile');
    Route::patch('/profile', function (\Illuminate\Http\Request $request) {
        $user = auth()->user();
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'password' => 'nullable|string|min:8|confirmed',
        ]);
        if ($data['password']) {
            $data['password'] = \Illuminate\Support\Facades\Hash::make($data['password']);
        } else {
            unset($data['password']);
        }
        $user->update($data);
        return back()->with('success', 'Perfil actualizado exitosamente.');
    })->name('profile.update');
    Route::patch('/appointments/{appointment}/cancel', function (\App\Models\Appointment $appointment) {
        if ($appointment->user_id !== auth()->id()) {
            abort(403);
        }
        if (!in_array($appointment->status, ['pending', 'confirmed'])) {
            return back()->with('error', 'No se puede cancelar esta cita.');
        }
        $appointment->update(['status' => 'cancelled', 'cancellation_reason' => 'Cancelado por el cliente']);
        return back()->with('success', 'Cita cancelada exitosamente.');
    })->name('appointments.cancel');
    Route::get('/history', function () {
        $user = auth()->user();
        $appointments = \App\Models\Appointment::with(['service', 'barber.user', 'payment'])
            ->where('user_id', $user->id)
            ->latest()
            ->paginate(15);
        $payments = \App\Models\Payment::with(['appointment.service'])
            ->whereIn('appointment_id', $appointments->pluck('id'))
            ->latest()
            ->get();
        $totalAppointments = \App\Models\Appointment::where('user_id', $user->id)->count();
        $totalSpent = \App\Models\Payment::whereIn('appointment_id', function ($q) use ($user) {
            $q->select('id')->from('appointments')->where('user_id', $user->id);
        })->where('status', 'paid')->sum('amount');
        return view('customer.history', compact('appointments', 'payments', 'totalAppointments', 'totalSpent'));
    })->name('history');
});

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', Dashboard::class)->name('dashboard');
    Route::get('/calendar', Calendar::class)->name('calendar');
    Route::get('/appointments', AppointmentManager::class)->name('appointments');
    Route::get('/barbers', BarberManager::class)->name('barbers');
    Route::get('/services', ServiceManager::class)->name('services');
    Route::get('/customers', CustomerManager::class)->name('customers');
    Route::get('/finance', FinanceManager::class)->name('finance');
    Route::get('/reports', Reports::class)->name('reports');
    Route::get('/settings', Settings::class)->name('settings');
    Route::get('/gallery', GalleryManager::class)->name('gallery');
    Route::get('/coupons', CouponManager::class)->name('coupons');
});

Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/');
})->middleware('auth')->name('logout');

Route::middleware(['auth', 'role:admin,barber'])->prefix('barber')->name('barber.')->group(function () {
    Route::get('/dashboard', function () {
        $barber = auth()->user()->barber;
        $today = \Carbon\Carbon::today();
        $todayAppointments = \App\Models\Appointment::with(['customer.user', 'service'])
            ->where('barber_id', $barber?->id)
            ->whereDate('start_time', $today)
            ->orderBy('start_time')
            ->get();
        $todayCount = $todayAppointments->count();
        $pendingCount = $todayAppointments->whereIn('status', ['pending', 'confirmed'])->count();
        $todayRevenue = $todayAppointments->where('status', 'completed')->sum('total_price');
        $weekSummary = collect();
        foreach (['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'] as $i => $dayName) {
            $date = \Carbon\Carbon::now()->startOfWeek()->addDays($i);
            $count = \App\Models\Appointment::where('barber_id', $barber?->id)->whereDate('start_time', $date)->count();
            $weekSummary->push(['name' => __($dayName), 'date' => $date->format('d/m'), 'count' => $count, 'is_today' => $date->isToday()]);
        }
        return view('barber.dashboard', compact('todayAppointments', 'todayCount', 'pendingCount', 'todayRevenue', 'weekSummary'));
    })->name('dashboard');
    Route::get('/appointments', function (\Illuminate\Http\Request $request) {
        $barber = auth()->user()->barber;
        $query = \App\Models\Appointment::with(['customer.user', 'service'])
            ->where('barber_id', $barber?->id);
        if ($request->status) $query->where('status', $request->status);
        if ($request->date) $query->whereDate('start_time', $request->date);
        $appointments = $query->orderBy('start_time', 'desc')->paginate(15);
        return view('barber.appointments', compact('appointments'));
    })->name('appointments');
    Route::patch('/appointments/{appointment}/start', function (\App\Models\Appointment $appointment) {
        if ($appointment->barber_id !== auth()->user()->barber?->id) abort(403);
        $appointment->update(['status' => 'in_progress']);
        return back()->with('success', 'Cita iniciada.');
    })->name('appointments.start');
    Route::patch('/appointments/{appointment}/complete', function (\App\Models\Appointment $appointment) {
        if ($appointment->barber_id !== auth()->user()->barber?->id) abort(403);
        $appointment->update(['status' => 'completed']);
        return back()->with('success', 'Cita completada.');
    })->name('appointments.complete');
    Route::patch('/appointments/{appointment}/cancel', function (\App\Models\Appointment $appointment) {
        if ($appointment->barber_id !== auth()->user()->barber?->id) abort(403);
        $appointment->update(['status' => 'cancelled', 'cancellation_reason' => 'Cancelado por el barbero']);
        return back()->with('success', 'Cita cancelada.');
    })->name('appointments.cancel');
    Route::get('/schedule', function () {
        $barber = auth()->user()->barber;
        $exceptions = $barber ? \App\Models\DateOverride::where('barber_id', $barber->id)->orderBy('date')->get() : collect();
        return view('barber.schedule', compact('barber', 'exceptions'));
    })->name('schedule');
    Route::post('/schedule', function (\Illuminate\Http\Request $request) {
        $barber = auth()->user()->barber;
        $barber?->update(['is_active' => $request->boolean('available', true)]);
        return back()->with('success', 'Horario actualizado.');
    })->name('schedule.update');
    Route::get('/earnings', function (\Illuminate\Http\Request $request) {
        $barber = auth()->user()->barber;
        $commissionRate = $barber?->commission ?? 40;
        $query = \App\Models\Appointment::where('barber_id', $barber?->id)->where('status', 'completed');
        $period = $request->period ?? 'all';
        $dateFrom = $request->dateFrom;
        $dateTo = $request->dateTo;
        if ($period === 'today') { $query->whereDate('start_time', today()); }
        elseif ($period === 'week') { $query->whereBetween('start_time', [now()->startOfWeek(), now()->endOfWeek()]); }
        elseif ($period === 'month') { $query->whereMonth('start_time', now()->month)->whereYear('start_time', now()->year); }
        elseif ($period === 'year') { $query->whereYear('start_time', now()->year); }
        if ($dateFrom) $query->whereDate('start_time', '>=', $dateFrom);
        if ($dateTo) $query->whereDate('start_time', '<=', $dateTo);
        $appointments = $query->orderBy('start_time', 'desc')->paginate(15);
        $totalEarned = \App\Models\Appointment::where('barber_id', $barber?->id)->where('status', 'completed')->sum('total_price');
        $monthEarned = \App\Models\Appointment::where('barber_id', $barber?->id)->where('status', 'completed')
            ->whereMonth('start_time', now()->month)->whereYear('start_time', now()->year)->sum('total_price');
        $totalAmount = $query->sum('total_price');
        $periodCommission = $totalAmount * $commissionRate / 100;
        return view('barber.earnings', compact('appointments', 'totalEarned', 'monthEarned', 'commissionRate', 'periodCommission'));
    })->name('earnings');
});
