<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable; 
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable
{
    use Notifiable;

    // Don't add create and update timestamps in database.
    public $timestamps  = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
         'photo_path', 'name', 'email', 'password', 
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 
    ];

    /**
     * The cards this user owns.
     */
    public function cards() {
      return $this->hasMany('App\Models\Card');
    }

    public function photoPath()
    {
        return $this->belongsTo(Image::class, 'photo_path');
    }

    public function getPhotoPath()
    {   
        return $this->photo_path;
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }
}
