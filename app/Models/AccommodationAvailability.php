<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccommodationAvailability extends Model
{
    use HasFactory;
    //
    protected $fillable = [
        'accommodation_id',
        'start_date',
        'end_date',
        'availability',
        'status',
    ];

    public function accommodation()
    {
        return $this->belongsTo(Accommodation::class, 'accommodation_id');
    }
}
