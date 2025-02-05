<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccommodationAmenity extends Model
{
    use HasFactory;
    //
    protected $fillable = [
        'accommodation_id',
        'title',
        'description',
        'status'
    ];
}
