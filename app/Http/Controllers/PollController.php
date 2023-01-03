<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Event;
use App\Models\Photo;
use App\Models\Poll;
use App\Models\Poll_choice;
use App\Models\Poll_vote;
use App\Models\Event_poll;

use Illuminate\Support\Facades\Auth;
use App\Models\User_event;
use Illuminate\Support\Facades\Validator;

class PollController extends Controller
{
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'question' => 'required|string|min:3|max:120',
            'option_1' => 'required|string|min:3|max:120',
            'poption_2' => 'required|string|min:3|max:120',
        ]);
    }


    public function show_create_poll($id)
  {
    $event = Event::find($id);
        if (Auth::check()) {
          $isModerator = User_event::where('event_id', $id)->where('user_id', Auth::id())->where('role', 'Moderator')->first();
          if ($event->owner_id == Auth::id() or $isModerator != null){
            return view('pages.poll_create', ['event' => $event]);
          }
          return redirect('/event/'.$id);
        } else {
          return redirect('/login'); 
        }
  }

  public function create_poll(Request $request, $id)
  {
    $data = $request->all();
    $event = Event::find($id);
    $counter = 0;


    
    foreach ($data as $i => $line){
      if ($counter > 0) {
        $validator = Validator::make(
          ['name' => $line],
          ['name' => 'required'|'min:3'|'max:120']);
      }
      $counter++;
    }

    $poll = Poll::create([
        'event_id' => $id,
        'question' => $request->input('question'),
    ]);
    $counter = 0;
    foreach ($data as $option){
      if ($counter > 1) {
        Poll_choice::create([
          'poll_id' => $poll->id,
          'choice'  => $option,
        ]);
      }
      $counter++;
    }
    return redirect('event/'.$id)->with('message', 'Poll created successfully!');
  }

  public function vote_in_poll($event_id, $poll_id, $choice_id)
  {
    $user = Auth::id();
    $user_event = User_event::where('event_id', $event_id)->where('user_id', $user)->first();
    if ($user_event != null and ($user_event->role == 'Owner' or 
    $user_event->role == 'Moderator' or $user_event->role == 'Participant')){
      $vote = Poll_vote::where('user_id', $user)->where('event_id', $event_id)->where('poll_id', $poll_id)->first();
      if ($vote == null){
        Event_poll::create([
          'user_id' => $user,
          'event_id' => $event_id,
          'poll_id' => $poll_id,
        ]);
        
        Poll_vote::create([
          'user_id' => $user,
          'event_id' => $event_id,
          'poll_id' => $poll_id,
          'choice_id' => $choice_id,
        ]);
      } else {
        return redirect('event/'.$event_id)->with('message', 'You already voted!');
      }
    } else {
      return redirect('event/'.$event_id);
    }
    return redirect('event/'.$event_id)->with('message', 'You vote was counted!');
  }
}
