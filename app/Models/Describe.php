<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Describe extends Model
{
    use HasFactory;
    //
    protected $fillable = [
        'describe',
        'status'
    ];

    protected $casts = [
        'status' =>'boolean'
    ];

    protected $appends = [
        'icon'
    ];
    public function getIconAttribute()
    {
        $folder = config('services.images.folder');
        return asset($folder.'/describes/'.$this->id.'.png');
    }
}
