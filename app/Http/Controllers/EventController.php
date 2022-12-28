<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


use App\Models\Event;
use App\Models\User;
use App\Models\User_event;
use App\Models\Comment;


class EventController extends Controller{ 


    public function show($id){
        $user = Auth::id();
        $event = Event::find($id);

        $role = User_event::where('user_id', $user)->where('event_id', $event->id)->first();
        if ($role === null){
          $role = 'Guest';
        } else {
          $role = $role->role;
        }

        if (Auth::check()) {        // check, if user is loged in
          if ($event){              // check, if event is exist
            return view('pages.event', ['event' => $event, 'role' => $role]);
          } else {
            abort('404');
          }
        } else{
          return redirect('/login');
        }
      }
    
      public function show_edit($id){
        $event = Event::find($id);
        if (Auth::check()) {
          if (User::id() === $event->owner_id){        //should be changed on veryfing the owner
            return view('pages.event_edit', ['event' => $event]);
          }
        } else {
          return redirect('/login'); 
        }
      }

      public function show_create(){
        return view('pages.event_create');
      }


      public function create(Request $request)
    {
      $userId = Auth::id(); 
      $event = Event::create([
          'owner_id' => $userId,
          'title' => $request->input('title'),
          'description' => $request->input('description'),
          'location' => $request->input('location'),
      ]);
      return redirect('home')->with('message', 'Event created successfully!');
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
        return view('pages.all_events', ['event' => $event]);
    }


    public function list_participations()
    {
        $event = Event::whereIn('id', function($query){
          $query->select('event_id')
            ->from(with(new User_event)->getTable())
            ->where('user_id', Auth::id());
        })->get();
        return view('pages.all_events', ['event' => $event]);
    }



    public function delete(Request $request)
    {   
       
        $id = $request->input('id');
        $event= Event::find($id);
        /* 
        $comments = $event->comments();
        foreach ($comments as $comment){
          $comment->votes()->delete();
          if($comment->event() == $event){
            $comment->delete();
          }
        }
        */
        $event->delete();
        return redirect('/home');
    }

    function index(Request $request) {
      
      $events_query = Event::query();

      $search_param = $request->query('q');

      if ($search_param) {
          $events_query = Event::search($search_param);
      }
      
      $events = $events_query->get();

      return view('index', compact('events', 'search_param'));
  }
  


    public function search(){
      $search_text = $_GET['search'];

    $event = Event::where(function ($event) use($search_text) {
      $event->where('title', 'ilike', '%' . $search_text. '%')
         ->orWhere('description', 'ilike', '%' . $search_text. '%');
    })  ->get();
  return view('pages.search',compact('event'));
  }

  public function join($id){
    $user = Auth::id();
    $event = Event::find($id);

    User_event::create([
      'event_id' => $event->id,
      'user_id'  => $user,
      'role' => 'Participant'
    ]);
    return redirect("/event/$id");
  }

  public function quit($id){
    $user = Auth::id();
    $event = Event::find($id);
    $role = User_event::where('user_id', $user)->where('event_id', $id)->delete();
    return redirect("/event/$id");
  }

}

