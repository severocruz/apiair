<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AccommodationAspect extends Model
{
    use HasFactory;
    //
    protected $fillable = [
        'accommodation_id',
        'aspect_id',
        'status'
    ];

    public function accommodation(): BelongsTo{
        return $this->belongsTo(Accommodation::class,'accommodation_id' );
    }

    public function aspect():BelongsTo{
        return $this->belongsTo(Aspect::class,'aspect_id');
    }
}
