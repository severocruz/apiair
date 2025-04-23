<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccommodationDiscount extends Model
{
    use HasFactory;
    //
    protected $fillable = [
        'accommodation_id',
        'discount_valuea',
        'discount_valueb',
        'discount_valuec',
        'discount_valued',
        'status',
    ];

    protected $casts = [
        'status' =>'boolean'
    ];


}
