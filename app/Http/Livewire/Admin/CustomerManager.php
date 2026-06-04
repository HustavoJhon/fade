<?php

namespace App\Http\Livewire\Admin;

use App\Models\Appointment;
use App\Models\Customer;
use App\Models\Payment;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;

#[Layout('layouts.admin')]
class CustomerManager extends Component
{
    use WithPagination;

    public string $search = '';
    public string $status = '';
    public int $perPage = 15;
    public ?int $viewingCustomerId = null;

    protected $queryString = ['search', 'status', 'perPage'];

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingStatus(): void
    {
        $this->resetPage();
    }

    public function updatingPerPage(): void
    {
        $this->resetPage();
    }

    public function view(int $id): void
    {
        $this->viewingCustomerId = $id;
    }

    public function closeView(): void
    {
        $this->viewingCustomerId = null;
    }

    public function getCustomerHistoryProperty()
    {
        if (!$this->viewingCustomerId) {
            return null;
        }

        $customer = Customer::with('user')->findOrFail($this->viewingCustomerId);

        $appointments = Appointment::where('customer_id', $this->viewingCustomerId)
            ->with(['barber.user', 'service', 'payment'])
            ->orderBy('start_time', 'desc')
            ->get();

        $payments = Payment::whereHas('appointment', fn($q) => $q->where('customer_id', $this->viewingCustomerId))
            ->with('appointment')
            ->latest()
            ->get();

        $totalSpent = $payments->where('status', 'paid')->sum('amount');
        $totalVisits = $appointments->count();
        $completedVisits = $appointments->where('status', 'completed')->count();
        $averageRating = $customer->reviews()->avg('rating');

        return (object) [
            'customer' => $customer,
            'appointments' => $appointments,
            'payments' => $payments,
            'totalSpent' => $totalSpent,
            'totalVisits' => $totalVisits,
            'completedVisits' => $completedVisits,
            'averageRating' => $averageRating,
            'memberSince' => $customer->created_at->format('M Y'),
        ];
    }

    public function render()
    {
        $query = Customer::with(['user', 'appointments']);

        if ($this->search) {
            $query->whereHas('user', fn($q) => $q->where('name', 'like', "%{$this->search}%")
                ->orWhere('email', 'like', "%{$this->search}%")
                ->orWhere('phone', 'like', "%{$this->search}%"));
        }

        return view('livewire.admin.customer-manager', [
            'customers' => $query->orderBy('id', 'desc')->paginate($this->perPage),
        ]);
    }
}
