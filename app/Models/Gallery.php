<?php

namespace App\Models;

use App\Models\Barber;
use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    protected $fillable = [
        'barber_id',
        'image',
        'caption',
        'sort_order',
        'is_active',
    ];

    public function barber()
    {
        return $this->belongsTo(Barber::class);
    }
}
