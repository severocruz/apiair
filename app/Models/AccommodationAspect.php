<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccommodationAspect extends Model
{
    use HasFactory;
    //
    protected $fillable = [
        'accommodation_id',
        'aspect_id',
        'status'
    ];
}
