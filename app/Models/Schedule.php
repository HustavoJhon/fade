<?php

namespace App\Models;

use App\Models\Barber;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Schedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'barber_id',
        'day_of_week',
        'start_time',
        'end_time',
        'is_available',
    ];

    public function barber()
    {
        return $this->belongsTo(Barber::class);
    }
}
