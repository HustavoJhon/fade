<?php

namespace App\Models;

use App\Models\Appointment;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Income extends Model
{
    protected $fillable = [
        'appointment_id',
        'description',
        'amount',
        'category',
        'payment_method',
        'recorded_by',
        'recorded_at',
    ];

    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }

    public function recordedBy()
    {
        return $this->belongsTo(User::class, 'recorded_by');
    }
}
