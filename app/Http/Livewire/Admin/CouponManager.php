<?php

namespace App\Http\Livewire\Admin;

use App\Models\Coupon;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;

#[Layout('layouts.admin')]
class CouponManager extends Component
{
    use WithPagination;

    public string $search = '';
    public ?int $editingCouponId = null;

    public $code;
    public $discount_type = 'percentage';
    public $discount_value;
    public $min_appointment_amount;
    public $max_uses;
    public $expires_at;
    public $is_active = true;

    protected function rules(): array
    {
        $uniqueRule = 'unique:coupons,code';
        if ($this->editingCouponId) {
            $uniqueRule .= ',' . $this->editingCouponId;
        }

        return [
            'code' => ['required', 'string', 'max:50', $uniqueRule],
            'discount_type' => 'required|in:percentage,fixed',
            'discount_value' => 'required|numeric|min:0',
            'min_appointment_amount' => 'nullable|numeric|min:0',
            'max_uses' => 'nullable|integer|min:1',
            'expires_at' => 'nullable|date|after_or_equal:today',
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
        $this->editingCouponId = null;
        $this->code = strtoupper(Str::random(8));
        $this->dispatch('show-coupon-modal');
    }

    public function store(): void
    {
        $this->validate();

        Coupon::create([
            'code' => strtoupper($this->code),
            'discount_type' => $this->discount_type,
            'discount_value' => $this->discount_value,
            'min_appointment_amount' => $this->min_appointment_amount,
            'max_uses' => $this->max_uses,
            'expires_at' => $this->expires_at ? Carbon::parse($this->expires_at) : null,
            'is_active' => $this->is_active,
        ]);

        session()->flash('message', 'Cupón creado exitosamente.');
        $this->dispatch('close-modal');
        $this->resetInputFields();
    }

    public function edit(int $id): void
    {
        $coupon = Coupon::findOrFail($id);
        $this->editingCouponId = $id;
        $this->code = $coupon->code;
        $this->discount_type = $coupon->discount_type;
        $this->discount_value = $coupon->discount_value;
        $this->min_appointment_amount = $coupon->min_appointment_amount;
        $this->max_uses = $coupon->max_uses;
        $this->expires_at = $coupon->expires_at?->format('Y-m-d');
        $this->is_active = $coupon->is_active;

        $this->dispatch('show-coupon-modal');
    }

    public function update(): void
    {
        $this->validate();

        $coupon = Coupon::findOrFail($this->editingCouponId);
        $coupon->update([
            'code' => strtoupper($this->code),
            'discount_type' => $this->discount_type,
            'discount_value' => $this->discount_value,
            'min_appointment_amount' => $this->min_appointment_amount,
            'max_uses' => $this->max_uses,
            'expires_at' => $this->expires_at ? Carbon::parse($this->expires_at) : null,
            'is_active' => $this->is_active,
        ]);

        session()->flash('message', 'Cupón actualizado exitosamente.');
        $this->dispatch('close-modal');
        $this->resetInputFields();
    }

    public function destroy(int $id): void
    {
        Coupon::findOrFail($id)->delete();
        session()->flash('message', 'Cupón eliminado.');
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    private function resetInputFields(): void
    {
        $this->code = null;
        $this->discount_type = 'percentage';
        $this->discount_value = null;
        $this->min_appointment_amount = null;
        $this->max_uses = null;
        $this->expires_at = null;
        $this->is_active = true;
    }

    public function render()
    {
        $query = Coupon::query();

        if ($this->search) {
            $query->where('code', 'like', "%{$this->search}%");
        }

        return view('livewire.admin.coupon-manager', [
            'coupons' => $query->orderBy('id', 'desc')->paginate(15),
        ]);
    }
}
