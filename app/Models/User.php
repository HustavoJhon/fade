<?php

namespace App\Models;

use App\Models\Barber;
use App\Models\Customer;
use App\Models\Appointment;
use App\Models\Income;
use App\Models\Expense;
use App\Models\AuditLog;
use App\Models\AppNotification;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone',
        'avatar',
        'is_active',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    public function barber()
    {
        return $this->hasOne(Barber::class);
    }

    public function customer()
    {
        return $this->hasOne(Customer::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class, 'user_id');
    }

    public function notifications()
    {
        return $this->hasMany(AppNotification::class);
    }

    public function auditLogs()
    {
        return $this->hasMany(AuditLog::class);
    }

    public function incomes()
    {
        return $this->hasMany(Income::class, 'recorded_by');
    }

    public function expenses()
    {
        return $this->hasMany(Expense::class, 'recorded_by');
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isBarber(): bool
    {
        return $this->role === 'barber';
    }

    public function isCustomer(): bool
    {
        return $this->role === 'customer';
    }
}
