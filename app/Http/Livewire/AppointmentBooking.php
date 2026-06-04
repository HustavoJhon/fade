<?php

namespace App\Http\Livewire;

use App\Models\Appointment;
use App\Models\Barber;
use App\Models\Customer;
use App\Models\DateOverride;
use App\Models\Schedule;
use App\Models\Service;
use App\Models\User;
use App\Notifications\AppointmentCreated;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.public')]
class AppointmentBooking extends Component
{
    public int $step = 1;
    public ?int $selectedService = null;
    public ?int $selectedBarber = null;
    public ?string $selectedDate = null;
    public ?string $selectedTime = null;
    public ?string $customerName = null;
    public ?string $customerEmail = null;
    public ?string $customerPhone = null;
    public ?string $notes = null;
    public array $availableSlots = [];
    public ?int $serviceDuration = null;
    public ?string $servicePrice = null;
    public ?string $serviceName = null;
    public ?string $barberName = null;
    public bool $showSuccessModal = false;

    protected array $rules = [
        'selectedService' => 'required|exists:services,id',
        'selectedBarber' => 'required|exists:barbers,id',
        'selectedDate' => 'required|date|after_or_equal:today',
        'selectedTime' => 'required|date_format:H:i',
        'customerName' => 'required|string|max:255',
        'customerEmail' => 'required|email|max:255',
        'customerPhone' => 'nullable|string|max:20',
        'notes' => 'nullable|string|max:500',
    ];

    public function getServicesProperty()
    {
        return Service::where('is_active', true)->get();
    }

    public function getBarbersProperty()
    {
        if (!$this->selectedService) {
            return collect();
        }

        return Barber::with('user')
            ->where('is_active', true)
            ->get();
    }

    public function selectService(int $serviceId): void
    {
        $service = Service::findOrFail($serviceId);
        $this->selectedService = $serviceId;
        $this->serviceDuration = $service->duration;
        $this->servicePrice = $service->price;
        $this->serviceName = $service->name;
        $this->selectedBarber = null;
        $this->selectedDate = null;
        $this->selectedTime = null;
        $this->availableSlots = [];
        $this->step = 2;
    }

    public function selectBarber(int $barberId): void
    {
        $barber = Barber::with('user')->findOrFail($barberId);
        $this->selectedBarber = $barberId;
        $this->barberName = $barber->user?->name;
        $this->selectedDate = null;
        $this->selectedTime = null;
        $this->availableSlots = [];
        $this->step = 3;
    }

    public function selectDate(string $date): void
    {
        $this->selectedDate = $date;
        $this->selectedTime = null;
        $this->getAvailableSlots();
    }

    public function getAvailableSlots(): void
    {
        $this->validateOnly('selectedDate');
        $this->validateOnly('selectedBarber');

        if (!$this->selectedBarber || !$this->selectedDate || !$this->serviceDuration) {
            $this->availableSlots = [];
            return;
        }

        $date = Carbon::parse($this->selectedDate);
        $dayOfWeek = $date->dayOfWeek;
        $dateStr = $date->format('Y-m-d');

        $schedule = Schedule::where('barber_id', $this->selectedBarber)
            ->where('day_of_week', $dayOfWeek)
            ->where('is_available', true)
            ->first();

        if (!$schedule) {
            $this->availableSlots = [];
            $this->dispatch('slots-updated');
            return;
        }

        $override = DateOverride::where('barber_id', $this->selectedBarber)
            ->where('date', $dateStr)
            ->first();

        $slotStart = $override
            ? ($override->is_available ? Carbon::parse($override->start_time) : null)
            : Carbon::parse($schedule->start_time);

        $slotEnd = $override
            ? ($override->is_available ? Carbon::parse($override->end_time) : null)
            : Carbon::parse($schedule->end_time);

        if (!$slotStart || !$slotEnd) {
            $this->availableSlots = [];
            $this->dispatch('slots-updated');
            return;
        }

        if ($date->isToday()) {
            $now = Carbon::now();
            $slotStart = $slotStart->gt($now) ? $slotStart : $now->ceilMinute(30);
        }

        $existingAppointments = Appointment::where('barber_id', $this->selectedBarber)
            ->whereDate('start_time', $dateStr)
            ->whereIn('status', ['pending', 'confirmed'])
            ->get(['start_time', 'end_time']);

        $slots = [];
        $current = $slotStart->copy();
        $duration = $this->serviceDuration;

        while ($current->copy()->addMinutes($duration)->lte($slotEnd)) {
            $slotEndTime = $current->copy()->addMinutes($duration);
            $isBooked = $existingAppointments->contains(function ($apt) use ($current, $slotEndTime) {
                $aptStart = Carbon::parse($apt->start_time);
                $aptEnd = Carbon::parse($apt->end_time);
                return $current->lt($aptEnd) && $slotEndTime->gt($aptStart);
            });

            if (!$isBooked) {
                $slots[] = $current->format('H:i');
            }

            $current->addMinutes(30);
        }

        $this->availableSlots = $slots;
        $this->dispatch('slots-updated');
    }

    public function selectTime(string $time): void
    {
        $this->selectedTime = $time;
        $this->step = 4;
    }

    public function back(): void
    {
        if ($this->step > 1) {
            $this->step--;
        }
    }

    public function updatedSelectedDate(): void
    {
        $this->selectedTime = null;
        $this->availableSlots = [];
        if ($this->selectedDate) {
            $this->getAvailableSlots();
        }
    }

    public function submitBooking(): void
    {
        $this->validate();

        if (!$this->selectedTime || !$this->serviceDuration) {
            $this->addError('selectedTime', 'Por favor selecciona un horario disponible.');
            return;
        }

        $startTime = Carbon::parse($this->selectedDate . ' ' . $this->selectedTime);
        $endTime = $startTime->copy()->addMinutes($this->serviceDuration);

        $conflict = Appointment::where('barber_id', $this->selectedBarber)
            ->whereDate('start_time', $this->selectedDate)
            ->whereIn('status', ['pending', 'confirmed'])
            ->where(function ($q) use ($startTime, $endTime) {
                $q->whereBetween('start_time', [$startTime, $endTime])
                  ->orWhereBetween('end_time', [$startTime, $endTime])
                  ->orWhere(function ($q) use ($startTime, $endTime) {
                      $q->where('start_time', '<=', $startTime)
                        ->where('end_time', '>=', $endTime);
                  });
            })
            ->exists();

        if ($conflict) {
            $this->addError('selectedTime', 'Este horario ya no está disponible. Por favor selecciona otro.');
            return;
        }

        $user = User::where('email', $this->customerEmail)->first();
        $isNewUser = false;

        if (!$user) {
            $password = Str::random(16);
            $user = User::create([
                'name' => $this->customerName,
                'email' => $this->customerEmail,
                'password' => Hash::make($password),
                'role' => 'customer',
                'phone' => $this->customerPhone,
            ]);

            $customer = Customer::create([
                'user_id' => $user->id,
                'phone' => $this->customerPhone,
            ]);

            Password::sendResetLink(['email' => $this->customerEmail]);

            $isNewUser = true;
        } else {
            $customer = $user->customer;
            if (!$customer) {
                $customer = Customer::create([
                    'user_id' => $user->id,
                    'phone' => $this->customerPhone ?? $user->phone,
                ]);
            }
        }

        $service = Service::with('category')->find($this->selectedService);
        $barber = Barber::with('user')->find($this->selectedBarber);

        $appointment = Appointment::create([
            'customer_id' => $customer->id,
            'barber_id' => $this->selectedBarber,
            'service_id' => $this->selectedService,
            'user_id' => $user->id,
            'start_time' => $startTime,
            'end_time' => $endTime,
            'status' => 'pending',
            'total_price' => $service->price,
            'notes' => $this->notes,
        ]);

        $this->serviceName = $service->name;
        $this->barberName = $barber?->user?->name;

        $user->notify(new AppointmentCreated($appointment));

        $this->showSuccessModal = true;

        $this->dispatch('booking-completed', appointmentId: $appointment->id);
    }

    private function ensureCustomerData(): void
    {
        if (!$this->customerName) {
            $user = Auth::user();
            if ($user) {
                $this->customerName = $user->name;
                $this->customerEmail = $user->email;
                $this->customerPhone = $user->phone;
            }
        }
    }

    public function render()
    {
        $this->ensureCustomerData();

        return view('livewire.appointment-booking', [
            'services' => $this->services,
            'barbers' => $this->barbers,
        ]);
    }
}
