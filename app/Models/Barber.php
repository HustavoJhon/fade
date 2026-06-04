<?php

namespace App\Models;

use App\Models\User;
use App\Models\Schedule;
use App\Models\DateOverride;
use App\Models\Appointment;
use App\Models\Review;
use App\Models\Gallery;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Barber extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'bio',
        'specialties',
        'commission',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'specialties' => 'array',
            'is_active' => 'boolean',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }

    public function dateOverrides()
    {
        return $this->hasMany(DateOverride::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function gallery()
    {
        return $this->hasMany(Gallery::class);
    }
}
