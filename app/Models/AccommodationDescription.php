<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccommodationDescription extends Model
{
    use HasFactory;
    //
    protected $fillable = [
        'accommodation_id',
        'title',
        'description',
        'status'
        
    ];

    public function accommodation()
    {
        return $this->belongsTo(Accommodation::class, 'accommodation_id');
    }
}
