<?php

namespace App\Models;

//use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Event extends Model
{
    // use HasFactory;
    public $timestamps = false;

    protected $table = 'event';

    protected $fillable = [
        'owner_id', 'title', 'description', 'tags', 'start_date', 'end_date', 'is_public', 'location'
    ];

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function polls(): HasMany
    {
        return $this->hasMany(Poll::class);
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function toSearchableArray(){
        return [
            'owner_id' => $this->owner_id,
            'title' => $this->title,
            'description' => $this->description,
            'location' => $this->location,
            'tags' => $this->tags
        ];
    }

}