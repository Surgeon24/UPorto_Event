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
    
      public function show_edit($id){
        $event = Event::find($id);
        //$this->authorize('show', $user);
        //$comment = Comment::list();
        return view('pages.event_edit', ['event' => $event]);
      }

    public function update(Request $request, $id)
    {
      $event = Event::find($id);
      $event->title = $request->get('title');
      $event->save();
      return redirect('event/' . $id)->withSuccess('Your profile was successfully updated!');
    }

    public function list()
    {
        //if (!Auth::check()) return redirect('/login');
        //$this->authorize('list', Card::class);
        $event = Event::orderBy('id')->get();
        return view('pages.home', ['event' => $event]);
    }



    public function delete(Request $request)
    {   
       
        $id = $request->input('id');
        $event= Event::find($id);
        $event->comments()->delete();
        $event->delete();
        return redirect('/home');
    }
}