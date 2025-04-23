<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    //
    protected $fillable = [
        'user_id',
        'accommodation_id',
        'reserve_id',
        'comment',
        'qualification',
        'publication_date',
        'status'
    ];

    protected $casts = [
        'status' =>'boolean'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}
