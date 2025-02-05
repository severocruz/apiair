<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AccommodationService extends Model
{
    use HasFactory;

    protected $fillable = [
        'accommodation_id',
        'service_id',
        'status'
    ];

    //
}
