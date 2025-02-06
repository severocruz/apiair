<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aspect extends Model
{
    //descripciones del alojamiento dependiendo de la categoria p ej Casa, Habitacion
    use HasFactory;
    protected $fillable =[
        'description',
        'describe_id',
        'status'
    ];
    public function describe()
    {
        return $this->belongsTo(Describe::class,'describe_id');
    }
}
