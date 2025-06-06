<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class AccommodationInstruction extends Model
{
    use HasFactory;
    //
    protected $fillable = [
        'accommodation_id',
        'title',
        'description',
        'type',
        'status'
    ];

    protected $casts = [
        'status' =>'boolean'
    ];

    public function accommodation()
    {
        return $this->belongsTo(Accommodation::class, 'accommodation_id');
    }
}
