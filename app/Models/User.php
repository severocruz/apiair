<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'lastname',
        'email',
        'phone',
        'password',
        'profile_photo',
        'biography',
        'record_date',
        'verified',
        'document_number',
        'document_type',
        'document_photo_front',
        'document_photo_back',
        'confirm_photo',
        'status'
    ];

    
    protected $casts = [
        'verified' => 'boolean',
        'status' =>'boolean'
    ];

    protected $appends = [
        'profile_photo_url',
        'confirm_photo_url',
        'document_photo_front_url',
        'document_photo_back_url'
    ];

    public function getProfilePhotoUrlAttribute()
    {
        return $this->profile_photo ? asset(config('services.images.folder') . '/users/' . $this->profile_photo) : null;
    }

    public function getConfirmPhotoUrlAttribute()
    {
        return $this->confirm_photo ? asset(config('services.images.folder') . '/users/' . $this->confirm_photo) : null;
    }

    public function getDocumentPhotoFrontUrlAttribute()
    {
        return $this->document_photo_front ? asset(config('services.images.folder') . '/users/' . $this->document_photo_front) : null;
    }

    public function getDocumentPhotoBackUrlAttribute()
    {
        return $this->document_photo_back ? asset(config('services.images.folder') . '/users/' . $this->document_photo_back) : null;
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
