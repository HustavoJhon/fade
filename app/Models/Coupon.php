<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $fillable = [
        'code',
        'discount_type',
        'discount_value',
        'min_appointment_amount',
        'max_uses',
        'used_count',
        'expires_at',
        'is_active',
    ];
}
