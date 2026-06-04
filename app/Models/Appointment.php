<?php

namespace App\Models;

use App\Models\Customer;
use App\Models\Barber;
use App\Models\Service;
use App\Models\User;
use App\Models\Payment;
use App\Models\Review;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'barber_id',
        'service_id',
        'user_id',
        'start_time',
        'end_time',
        'status',
        'total_price',
        'notes',
        'cancellation_reason',
        'created_by',
    ];

    protected function casts(): array
    {
        return [
            'start_time' => 'datetime',
            'end_time' => 'datetime',
        ];
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function barber()
    {
        return $this->belongsTo(Barber::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    public function review()
    {
        return $this->hasOne(Review::class);
    }

    public function scopeByStatus(Builder $query, string $status): Builder
    {
        return $query->where('status', $status);
    }

    public function scopeByDate(Builder $query, string $date): Builder
    {
        return $query->whereDate('start_time', $date);
    }

    public function scopeByBarber(Builder $query, int $barberId): Builder
    {
        return $query->where('barber_id', $barberId);
    }

    public function canBeCancelled(): bool
    {
        return in_array($this->status, ['pending', 'confirmed']);
    }
}
