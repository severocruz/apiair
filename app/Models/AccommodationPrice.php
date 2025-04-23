<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class AccommodationPrice extends Model
{
    use HasFactory;
    //

    protected $fillable = [
        'accommodation_id',
        'price_night',
        'price_weekend',
        'type',
        'description',
        'status'
    ];

    protected $casts = [
        'status' =>'boolean'
    ];

    public function accommodation()
    {
        return $this->belongsTo(Accommodation::class,'accommodation_id');
    }

}
