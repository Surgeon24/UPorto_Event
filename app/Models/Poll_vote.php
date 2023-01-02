<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Poll_vote extends Model
{
    // use HasFactory;
    public $timestamps = false;

    protected $table = 'poll_vote';

    protected $fillable = [
        'user_id', 'event_id', 'poll_id', 'choice_id'
    ];
}
