<?php

namespace App\Models;

//use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CommentVote extends Model
{


    // use HasFactory;
    public $timestamps = false;

    protected $table = 'comment_votes';

    protected $fillable = [
         'user_id', 'comment_id', 'type',
    ];

    protected $hidden = [
        'user_id', 'comment_id', 
    ];

    public function comment():BelongsTo {
        return $this->belongsTo('App\Models\Comment');
    }
    


}