<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    /** @use HasFactory<\Database\Factories\PaymentFactory> */
    use HasFactory;

    protected $fillable = [
        'reserve_id',
        'mount',
        'method',
        'reference',
        'transaction_id',
        'transaction_at'
    ];
    public function reserve()
    {
        return $this->belongsTo(Reserve::class, 'reserve_id');
    }
}
