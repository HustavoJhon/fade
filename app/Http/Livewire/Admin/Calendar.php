<?php

namespace App\Http\Livewire\Admin;

use App\Models\Appointment;
use App\Models\Barber;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.admin')]
class Calendar extends Component
{
    public string $view = 'dayGridMonth';
    public ?string $barberFilter = null;
    public ?string $statusFilter = null;

    protected $queryString = ['view', 'barberFilter', 'statusFilter'];

    public function getBarbersProperty()
    {
        return Barber::with('user')->where('is_active', true)->get();
    }

    public function getEvents(): array
    {
        $query = Appointment::with(['customer.user', 'barber.user', 'service']);

        if ($this->barberFilter) {
            $query->where('barber_id', $this->barberFilter);
        }

        if ($this->statusFilter) {
            $query->where('status', $this->statusFilter);
        }

        return $query->get()->map(function ($appointment) {
            $colors = [
                'pending' => '#f59e0b',
                'confirmed' => '#10b981',
                'in_progress' => '#3b82f6',
                'completed' => '#6b7280',
                'cancelled' => '#ef4444',
                'no_show' => '#dc2626',
            ];

            return [
                'id' => $appointment->id,
                'title' => $appointment->customer?->user?->name . ' - ' . $appointment->service?->name,
                'start' => $appointment->start_time->format('Y-m-d\TH:i:s'),
                'end' => $appointment->end_time->format('Y-m-d\TH:i:s'),
                'color' => $colors[$appointment->status] ?? '#6b7280',
                'extendedProps' => [
                    'customer' => $appointment->customer?->user?->name,
                    'barber' => $appointment->barber?->user?->name,
                    'service' => $appointment->service?->name,
                    'status' => $appointment->status,
                    'price' => $appointment->total_price,
                    'notes' => $appointment->notes,
                ],
            ];
        })->toArray();
    }

    public function updateEvent(int $appointmentId, string $newStart, ?string $newEnd = null): void
    {
        $appointment = Appointment::findOrFail($appointmentId);
        $duration = $appointment->start_time->diffInMinutes($appointment->end_time);

        $appointment->update([
            'start_time' => $newStart,
            'end_time' => $newEnd ?? Carbon\Carbon::parse($newStart)->addMinutes($duration),
        ]);

        $this->dispatch('event-updated', appointmentId: $appointment->id);
    }

    public function filterByBarber(?string $barberId): void
    {
        $this->barberFilter = $barberId;
        $this->dispatch('filter-changed');
    }

    public function filterByStatus(?string $status): void
    {
        $this->statusFilter = $status;
        $this->dispatch('filter-changed');
    }

    public function render()
    {
        return view('livewire.admin.calendar', [
            'events' => $this->getEvents(),
            'barbers' => $this->barbers,
        ]);
    }
}
