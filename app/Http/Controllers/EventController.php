<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\CommentController;

use App\Models\Event;
//use App\Models\Comment;


class EventController extends Controller{ 

    
    public function show($id){
        $event = Event::find($id);
        //$this->authorize('show', $user);
        //$comment = Comment::list();
        return view('pages.event', ['event' => $event]);
      }
    
    /*
    public function show($id){
        $event = Event::find($id);
        //$this->authorize('show', $user);
        $comment = CommentController::list();
        return view('pages.event', ['event' => $event, 'comment' => $comment]);
    }
    */

    public function list()
    {
        //if (!Auth::check()) return redirect('/login');
        //$this->authorize('list', Card::class);
        $event = Event::orderBy('id')->get();
        return view('pages.home', ['event' => $event]);
    }
}