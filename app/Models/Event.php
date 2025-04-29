<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    //
    protected $fillable =[
        'reserve_id',
        'type',
        'event_date',
        'note',
        'photo_url',
        'status'
    ];
}
