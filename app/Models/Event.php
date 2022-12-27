<?php

namespace App\Models;

//use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Scout\Searchable;

class Event extends Model
{
    // use HasFactory;
    use Searchable;
    public $timestamps = false;

    protected $table = 'event';

    protected $fillable = [
        'title', 'description', 'start_date', 'is_public', 'location'
    ];

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function toSearchableArray(){
        return [
            'title' => $this->title,
            'description' => $this->description,
            'location' => $this->location
        ];
    }

}