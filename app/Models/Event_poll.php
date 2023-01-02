<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event_poll extends Model
{
    // use HasFactory;
    public $timestamps = false;

    protected $table = 'event_poll';

    protected $fillable = [
        'user_id', 'event_id', 'poll_id'
    ];
}
