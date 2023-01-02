<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Poll extends Model
{
    // use HasFactory;
    public $timestamps = false;

    protected $table = 'poll';

    protected $fillable = [
        'event_id', 'question', 'starts_at', 'ends_at'
    ];
}
