<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccommodationType extends Model
{
    //use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'status'
    ];

    protected $casts = [
        'status' =>'boolean'
    ];
}
