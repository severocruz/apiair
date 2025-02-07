<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AccommodationPhoto extends Model
{
    use HasFactory;

    protected $fillable = [
        'accommodation_id',
        'photo_url',
        'mainPhoto',
        'order',
        'status'
    ];

    public function accommodation()
    {
        return $this->belongsTo(Accommodation::class,'accommodation_id');
    }

    //
}
