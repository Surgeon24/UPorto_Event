<?php

namespace App\Models;

//use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Comment extends Model
{


    // use HasFactory;
    public $timestamps = false;

    protected $table = 'comments';

    protected $fillable = [
        'comment_text', 'user_id', 'event_id', 'comment_date'
    ];

    protected $hidden = [
        'user_id', 'event_id', 
    ];

    public function event():BelongsTo {
        return $this->belongsTo('App\Models\Event');
    }
        
    public function votes():HasMany {
        return $this->hasMany('App\Models\CommentVote');
    }

}