<?php

namespace App\Http\Controllers;


use App\Models\User;
use App\Models\Event;
use App\Models\Comment;
use App\Models\CommentVote;
use App\Notifications\CommentNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Notifications\WelcomeNotification;

class CommentController extends Controller
{

    public function create(Request $request)
    {

        Comment::create([
            'comment_text' => $request->input('content'),
            'user_id' => Auth::user()->id,
            'event_id' => $request->input('event_id'),
            
        ]);

        // sending notification 
        $event = Event::where('id', $request->input('event_id'))->first();
        $owner_id = $event->owner_id;
        $user = User::where('id', Auth::user()->id)->first();
        $owner = User::where('id', $owner_id)->first();
        
        
        $owner->notify(new CommentNotification($user, $event));
        
        return redirect()->back()->withSuccess('Your comment was successfully posted!');
    }

    
    public function delete(Request $request)
    {   
       
        $id = $request->input('id');
        $comment= Comment::find($id);
        $this->authorize('delete', $comment);
        $comment->votes()->delete();
        $comment->delete();
        return back();
    }

    public function like($id)
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
