<?php

namespace App\Models;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Model;

class LoyaltyPoint extends Model
{
    protected $fillable = [
        'customer_id',
        'points',
        'type',
        'reference_type',
        'reference_id',
        'expires_at',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
