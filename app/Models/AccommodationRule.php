<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AccommodationRule extends Model
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
