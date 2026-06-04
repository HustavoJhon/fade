<?php

namespace App\Http\Livewire\Admin;

use App\Models\Barber;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;

#[Layout('layouts.admin')]
class BarberManager extends Component
{
    use WithPagination;

    public string $search = '';
    public ?int $editingBarberId = null;

    public $user_id;
    public $name;
    public $email;
    public $password;
    public $phone;
    public $bio;
    public $specialties = [];
    public $commission;
    public $is_active = true;

    protected function rules(): array
    {
        $userId = $this->editingBarberId ? Barber::find($this->editingBarberId)?->user_id : null;

        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . ($userId ?? 'NULL') . ',id',
            'password' => $this->editingBarberId ? 'nullable|string|min:8' : 'required|string|min:8',
            'phone' => 'nullable|string|max:20',
            'bio' => 'nullable|string|max:1000',
            'specialties' => 'nullable|array',
            'commission' => 'nullable|numeric|min:0|max:100',
            'is_active' => 'boolean',
        ];
    }

    public function index(): void
    {
        $this->resetPage();
    }

    public function create(): void
    {
        $this->resetInputFields();
        $this->editingBarberId = null;
        $this->dispatch('show-barber-modal');
    }

    public function store(): void
    {
        $this->validate();

        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'role' => 'barber',
            'phone' => $this->phone,
            'is_active' => true,
        ]);

        Barber::create([
            'user_id' => $user->id,
            'bio' => $this->bio,
            'specialties' => $this->specialties,
            'commission' => $this->commission,
            'is_active' => $this->is_active,
        ]);

        session()->flash('message', 'Barbero creado exitosamente.');
        $this->dispatch('close-modal');
        $this->resetInputFields();
    }

    public function edit(int $id): void
    {
        $barber = Barber::with('user')->findOrFail($id);
        $this->editingBarberId = $id;
        $this->user_id = $barber->user_id;
        $this->name = $barber->user->name;
        $this->email = $barber->user->email;
        $this->phone = $barber->user->phone;
        $this->bio = $barber->bio;
        $this->specialties = $barber->specialties ?? [];
        $this->commission = $barber->commission;
        $this->is_active = $barber->is_active;
        $this->password = null;

        $this->dispatch('show-barber-modal');
    }

    public function update(): void
    {
        $this->validate();

        $barber = Barber::with('user')->findOrFail($this->editingBarberId);
        $user = $barber->user;

        $userData = [
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
        ];

        if ($this->password) {
            $userData['password'] = Hash::make($this->password);
        }

        $user->update($userData);

        $barber->update([
            'bio' => $this->bio,
            'specialties' => $this->specialties,
            'commission' => $this->commission,
            'is_active' => $this->is_active,
        ]);

        session()->flash('message', 'Barbero actualizado exitosamente.');
        $this->dispatch('close-modal');
        $this->resetInputFields();
    }

    public function destroy(int $id): void
    {
        $barber = Barber::with('user')->findOrFail($id);
        $barber->user->delete();
        $barber->delete();
        session()->flash('message', 'Barbero eliminado exitosamente.');
    }

    public function toggleActive(int $id): void
    {
        $barber = Barber::findOrFail($id);
        $barber->update(['is_active' => !$barber->is_active]);
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    private function resetInputFields(): void
    {
        $this->name = null;
        $this->email = null;
        $this->password = null;
        $this->phone = null;
        $this->bio = null;
        $this->specialties = [];
        $this->commission = null;
        $this->is_active = true;
    }

    public function render()
    {
        $query = Barber::with('user');

        if ($this->search) {
            $query->whereHas('user', fn($q) => $q->where('name', 'like', "%{$this->search}%")
                ->orWhere('email', 'like', "%{$this->search}%"));
        }

        return view('livewire.admin.barber-manager', [
            'barbers' => $query->orderBy('id', 'desc')->paginate(15),
        ]);
    }
}
