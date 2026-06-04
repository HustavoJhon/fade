<?php

namespace App\Http\Livewire\Admin;

use App\Models\Appointment;
use App\Models\Barber;
use App\Models\Customer;
use App\Models\Service;
use App\Models\User;
use App\Notifications\AppointmentCancelled;
use App\Notifications\AppointmentConfirmed;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;

#[Layout('layouts.admin')]
class AppointmentManager extends Component
{
    use WithPagination;

    public string $search = '';
    public ?string $statusFilter = null;
    public ?string $barberFilter = null;
    public ?string $dateFilter = null;
    public string $sortField = 'start_time';
    public string $sortDirection = 'desc';
    public ?int $editingAppointmentId = null;

    public $customer_id;
    public $barber_id;
    public $service_id;
    public $start_time;
    public $end_time;
    public $status = 'pending';
    public $total_price;
    public $notes;
    public $cancellation_reason;

    protected $queryString = ['search', 'statusFilter', 'barberFilter', 'dateFilter', 'sortField', 'sortDirection'];

    protected function rules(): array
    {
        return [
            'customer_id' => 'required|exists:customers,id',
            'barber_id' => 'required|exists:barbers,id',
            'service_id' => 'required|exists:services,id',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
            'status' => 'required|in:pending,confirmed,in_progress,completed,cancelled,no_show',
            'total_price' => 'required|numeric|min:0',
            'notes' => 'nullable|string|max:500',
            'cancellation_reason' => 'nullable|string|max:500',
        ];
    }

    public function getCustomersProperty()
    {
        return Customer::with('user')->get();
    }

    public function getBarbersProperty()
    {
        return Barber::with('user')->where('is_active', true)->get();
    }

    public function getServicesProperty()
    {
        return Service::where('is_active', true)->get();
    }

    public function index(): void
    {
        $this->resetPage();
    }

    public function create(): void
    {
        $this->resetInputFields();
        $this->editingAppointmentId = null;
        $this->dispatch('show-appointment-modal');
    }

    public function store(): void
    {
        $this->validate();

        Appointment::create([
            'customer_id' => $this->customer_id,
            'barber_id' => $this->barber_id,
            'service_id' => $this->service_id,
            'user_id' => Customer::find($this->customer_id)?->user_id,
            'start_time' => Carbon::parse($this->start_time),
            'end_time' => Carbon::parse($this->end_time),
            'status' => $this->status,
            'total_price' => $this->total_price,
            'notes' => $this->notes,
        ]);

        session()->flash('message', 'Cita creada exitosamente.');
        $this->dispatch('close-modal');
        $this->resetInputFields();
    }

    public function edit(int $id): void
    {
        $appointment = Appointment::findOrFail($id);
        $this->editingAppointmentId = $id;
        $this->customer_id = $appointment->customer_id;
        $this->barber_id = $appointment->barber_id;
        $this->service_id = $appointment->service_id;
        $this->start_time = $appointment->start_time->format('Y-m-d\TH:i');
        $this->end_time = $appointment->end_time->format('Y-m-d\TH:i');
        $this->status = $appointment->status;
        $this->total_price = $appointment->total_price;
        $this->notes = $appointment->notes;
        $this->cancellation_reason = $appointment->cancellation_reason;

        $this->dispatch('show-appointment-modal');
    }

    public function update(): void
    {
        $this->validate();

        $appointment = Appointment::findOrFail($this->editingAppointmentId);
        $appointment->update([
            'customer_id' => $this->customer_id,
            'barber_id' => $this->barber_id,
            'service_id' => $this->service_id,
            'start_time' => Carbon::parse($this->start_time),
            'end_time' => Carbon::parse($this->end_time),
            'status' => $this->status,
            'total_price' => $this->total_price,
            'notes' => $this->notes,
            'cancellation_reason' => $this->status === 'cancelled' ? $this->cancellation_reason : null,
        ]);

        session()->flash('message', 'Cita actualizada exitosamente.');
        $this->dispatch('close-modal');
        $this->resetInputFields();
    }

    public function destroy(int $id): void
    {
        Appointment::findOrFail($id)->delete();
        session()->flash('message', 'Cita eliminada exitosamente.');
    }

    public function changeStatus(int $id, string $status): void
    {
        $appointment = Appointment::findOrFail($id);
        $oldStatus = $appointment->status;
        $appointment->update(['status' => $status]);

        $user = $appointment->user;
        if ($user) {
            if ($status === 'confirmed' && $oldStatus !== 'confirmed') {
                $user->notify(new AppointmentConfirmed($appointment));
            } elseif ($status === 'cancelled' && $oldStatus !== 'cancelled') {
                $user->notify(new AppointmentCancelled($appointment));
            }
        }

        session()->flash('message', 'Estado de la cita actualizado.');
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    private function resetInputFields(): void
    {
        $this->customer_id = null;
        $this->barber_id = null;
        $this->service_id = null;
        $this->start_time = null;
        $this->end_time = null;
        $this->status = 'pending';
        $this->total_price = null;
        $this->notes = null;
        $this->cancellation_reason = null;
    }

    public function render()
    {
        $query = Appointment::with(['customer.user', 'barber.user', 'service']);

        if ($this->search) {
            $query->whereHas('customer.user', fn($q) => $q->where('name', 'like', "%{$this->search}%"))
                ->orWhereHas('barber.user', fn($q) => $q->where('name', 'like', "%{$this->search}%"))
                ->orWhereHas('service', fn($q) => $q->where('name', 'like', "%{$this->search}%"));
        }

        if ($this->statusFilter) {
            $query->where('status', $this->statusFilter);
        }

        if ($this->barberFilter) {
            $query->where('barber_id', $this->barberFilter);
        }

        if ($this->dateFilter) {
            $query->whereDate('start_time', $this->dateFilter);
        }

        $query->orderBy($this->sortField, $this->sortDirection);

        return view('livewire.admin.appointment-manager', [
            'appointments' => $query->paginate(15),
        ]);
    }
}
