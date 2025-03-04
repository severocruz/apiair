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
    'describe_id',
    'address',
    'city',
    'postal_code',
    'country',
    'latitude',
    'longitude',
    'guest_capacity',
    'number_rooms',
    'number_bathrooms',
    'number_beds',
    'price_night',
    'status'
    ];
    //


    public function user()
    {
        return $this->belongsTo(User::class, 'host_id');
    }

    public function type()
    {
        return $this->belongsTo(AccommodationType::class, 'type_id');
    }

    public function describe()
    {
        return $this->belongsTo(Describe::class, 'describe_id');
    }

    public function aspects(){
        return $this->hasMany(AccommodationAspect::class,'accommodation_id');
    }

    public function services(){
        return $this->hasMany(AccommodationService::class,'accommodation_id');
    }
    public function prices(){
        return $this->hasMany(AccommodationPrice::class,'accommodation_id');
    }

    public function photos(){
        return $this->hasMany(AccommodationPhoto::class,'accommodation_id');
    }

    public function discounts(){
        return $this->hasMany(AccommodationDiscount::class,'accommodation_id');
    }

}
