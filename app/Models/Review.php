<?php

namespace App\Models;

use App\Models\Appointment;
use App\Models\Customer;
use App\Models\Barber;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = [
        'appointment_id',
        'customer_id',
        'barber_id',
        'rating',
        'comment',
        'is_approved',
    ];

    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function barber()
    {
        return $this->belongsTo(Barber::class);
    }
}
