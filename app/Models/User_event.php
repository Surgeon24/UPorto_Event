<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User_event extends Model
{
    public $timestamps = false;
    protected $table = 'user_event';
    protected $fillable = ['role', 'event_id', 'user_id'];

    public function toSearchableArray(){
        return [
            'user_id' => $this->user_id,
            'event_id' => $this->event_id,
            'role' => $this->role
        ];
    }
}
