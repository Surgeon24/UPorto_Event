<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Models\Comment;
use App\Models\CommentVote;

class CommentController extends Controller
{

    public function create(Request $request)
    {

        Comment::create([
            'comment_text' => $request->input('content'),
            'user_id' => Auth::user()->id,
            'event_id' => $request->input('event_id'),
            
        ]);

        return redirect()->back()->withSuccess('Your comment was successfully posted!');
    }

    
    public function delete(Request $request)
    {   
       
        $id = $request->input('id');
        $comment= Comment::find($id);
        $comment->votes()->delete();
        $comment->delete();
        return back();
    }

    public function like(Request $request, $id)
    {   
        $like = CommentVote::where('comment_id', $id)->where('user_id', Auth::user()->id)->first();
        if($like == null){
            CommentVote::create([
                'comment_id' => $id,
                'user_id' => Auth::user()->id,
            ]);
        }
        else{
            $like->delete();
        }
        return Response()->json(['status' => 'ok'],200);
    }
}
