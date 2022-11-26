<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Models\CommentVote;

class CommentVoteController extends Controller
{


    public function show($id)
    {
        $comment_vote = CommentVote::find($id);
        //$this->authorize('show', $user);
        return $comment_vote;
    }
}