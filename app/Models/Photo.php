<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    // use HasFactory;
    public $timestamps = false;
    
    protected $table = 'photo';

    protected $fillable = [
        'event_id', 'image_path'
    ];
}
