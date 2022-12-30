<?php

namespace App\Http\Controllers;


use Carbon\Carbon;
use App\Models\User;
use App\Models\Event;


use App\Models\Comment;
use App\Models\User_event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Notifications\EventJoinNotification;
use App\Notifications\JoinRequestNotification;

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
          if (Auth::id() === $event->owner_id){        //should be changed on veryfing the owner
            return view('pages.event_edit', ['event' => $event]);
          }
        } else {
          return redirect('/login'); 
        }
      }

      public function show_create(){
        return view('pages.event_create');
      }



      protected function validator(array $data)
    {
        return Validator::make($data, [
            'title' => 'required|string|max:1',
            'description' => 'required|string|email|max:255',
            'location' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            
        ]);
    }

      public function create(Request $request)
    {
      $userId = Auth::id(); 

      $validated = $request->validate([
        'title' => 'required|max:20|unique:event',
        'description' => 'required|max:100',
        'location' => 'required|max:50',
        'start_date' => 'required',
        'end_date' => 'required'
      ]);

      if ($request->input('title') === null or $request->input('description') === null or $request->input('location') === null
       or $request->input('start_date') === null or $request->input('end_date') === null){
          return redirect('event_create')->with('message', 'fill empty fields!');
      }


      if($request->input('end_date') <= $request->input('start_date')){
        return redirect('event_create')->with('message', 'end date cannot be later than start date!');
      }


      if($request->input('start_date') <= Carbon::now()){
        return redirect('event_create')->with('message', 'Event cannot start in the past!');
      }
      

      $event = Event::create([
          'owner_id' => $userId,
          'title' => $request->input('title'),
          'description' => $request->input('description'),
          'location' => $request->input('location'),
          'start_date' => $request->input('start_date'),
          'end_date' => $request->input('end_date'),
          'is_public' => !$request->input('private'),
      ]);

      return redirect('home')->with('message', 'Event created successfully!');

    }



    public function update(Request $request, $id)
    {
      // $event = Event::find($id)->update(['title' => $request->get('title')]);
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
  


  public function join($id){
      $user = Auth::id();
      $event = Event::find($id);
      //backend protection
      $check = User_event::where('event_id', $event->id)->where('user_id', $user)->first();
      if ($check != null){
        return redirect("/event/$id");
      } else {
        if ($event->is_public){
          User_event::create([
            'event_id' => $event->id,
            'user_id'  => $user,
            'role' => 'Participant'
          ]);
          // sending notification
          $owner_id = $event->owner_id;
          $owner = User::where('id', $owner_id)->first();
          $user = User::where('id', Auth::user()->id)->first();
          $owner->notify(new EventJoinNotification($user));
        } else {
          User_event::create([
            'event_id' => $event->id,
            'user_id'  => $user,
            'role' => 'Unconfirmed'
          ]);


          $owner_id = $event->owner_id;
          $owner = User::where('id', $owner_id)->first();
          $user = User::where('id', Auth::user()->id)->first();
          $owner->notify(new JoinRequestNotification($user));

        }
      }


      return redirect("/event/$id");
  }

  public function quit($id){
    $user = Auth::id();
    $event = Event::find($id);
    //backend protection
    $check = User_event::where('event_id', $event->id)->where('user_id', $user)->first();
    if ($check != null and $check->role == 'Owner'){
      return redirect("/event/$id");
    } else{
      $role = User_event::where('user_id', $user)->where('event_id', $id)->delete();
    }
    return redirect("/event/$id");
  }



  public function show_participants($id)
  {
      $list = User::whereIn('id', function($query){
        $query->select('user_id')
          ->from(with(new User_event)->getTable()) 
          ->where('event_id', Event::find($id));
      })->get();

      return view('pages.all_participants', ['participants' => $list]);
  }
}

