<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccommodationAvailability extends Model
{
    use HasFactory;
    //
    protected $fillable = [
        'accommodation_id',
        'date',
        'availability',
        'status',
    ];
}
