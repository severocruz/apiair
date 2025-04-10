<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class VerificationCode extends Model
{
    use HasFactory;
    //
    protected $fillable =[
        'user_id',
        'code',
        'is_used',
        'expires_at'
    ];

}
