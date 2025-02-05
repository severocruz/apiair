<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccommodationDescribe extends Model
{
    use HasFactory;
    //
    protected $fillable = [
        'accommodation_id',
        'describe_id',
        'status'
    ];
}
