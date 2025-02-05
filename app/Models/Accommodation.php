<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Accommodation extends Model
{
    use HasFactory;
    protected $fillable =[
    'host_id',
    'title',
    'description',
    'type_id',
    'address',
    'city',
    'postal_code',
    'country',
    'latitude',
    'longitude',
    'guest_capacity',
    'number_rooms',
    'number_bathrooms',
    'price_night',
    'status'
    ];
    //
}
