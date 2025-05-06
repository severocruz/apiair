<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    /** @use HasFactory<\Database\Factories\ServiceFactory> */
    use HasFactory;
    protected $table = 'services';
    protected $fillable = [
        'name',
        'description',
        'type_id',
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
        return asset($folder.'/services/'.$this->id.'.png');
    }
}
