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

    protected $casts = [
        'status' =>'boolean'
    ];

    protected $appends = [
        'url'
    ];

    public function getUrlAttribute()
    {
        return url('public/images/accommodations/'.$this->photo_url);
    }

    public function accommodation()
    {
        return $this->belongsTo(Accommodation::class,'accommodation_id');
    }

    
    //
}
