<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AccommodationService extends Model
{
    use HasFactory;

    protected $fillable = [
        'accommodation_id',
        'service_id',
        'description',
        'status'
    ];

    public function accommodation()
    {
        return $this->belongsTo(Accommodation::class, 'accommodation_id');
    }

    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id');
    }

    //
}
