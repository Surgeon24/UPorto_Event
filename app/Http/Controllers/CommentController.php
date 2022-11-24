<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Models\Comment;

class CommentController extends Controller
{


    public function show($id)
    {
        $event = Comment::find($id);
        //$this->authorize('show', $user);
        return view('pages.event', ['event' => $event]);
    }


    public function list()
    {
        //if (!Auth::check()) return redirect('/login');
        //$this->authorize('list', Card::class);
        $comment = Comment::orderBy('id')->get();
        return view('pages.home', ['comment' => $comment]);
    }

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
        $comment->delete();
        return back();
    }
}
