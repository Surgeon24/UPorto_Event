<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Poll_choice extends Model
{
    // use HasFactory;
    public $timestamps = false;

    protected $table = 'poll_choice';

    protected $fillable = [
        'poll_id', 'choice'
    ];
}
