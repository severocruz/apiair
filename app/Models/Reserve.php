<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reserve extends Model
{
    use HasFactory;
    //
    protected $fillable = [
        'user_id',
        'accommodation_id',
        'start_date',
        'end_date',
        'number_guests',
        'total_price',
        'cash_discount',
        'commission',
        'state',
        'status'
    ];
}
