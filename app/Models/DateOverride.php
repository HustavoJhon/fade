<?php

namespace App\Models;

use App\Models\Barber;
use Illuminate\Database\Eloquent\Model;

class DateOverride extends Model
{
    protected $fillable = [
        'barber_id',
        'date',
        'start_time',
        'end_time',
        'is_available',
        'reason',
    ];

    public function barber()
    {
        return $this->belongsTo(Barber::class);
    }
}
