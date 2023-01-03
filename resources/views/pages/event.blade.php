@php
    use Carbon\Carbon;
    $now = Carbon::now();
    $startDate = new Carbon($event->start_date);
    $endDate = new Carbon($event->end_date);
    $duration = $endDate->diffInDays($startDate);
    $timeLeft = $startDate->diffInDays($now);
@endphp

<x-layout>
    <style>
        .card {
            /* Add shadows to create the "card" effect */
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
            transition: 0.3s;
        }

        /* On mouse-over, add a deeper shadow */
        .card:hover {
            box-shadow: 0 8px 16px 0 rgba(0, 0, 0, 0.2);
        }

        /* Add some padding inside the card container */
        .container {
            padding: 2px 16px;
        }

        .card {
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
            transition: 0.3s;
            border-radius: 5px;
            /* 5px rounded corners */
        }

        /* Add rounded corners to the top left and the top right corner of the image 
        */
        img {
            border-radius: 5px 5px 0 0;
        }


    .bar{
    background-color:#363230;
    color:white;
    border-radius: 15px;
    border: 1px #000 solid;
    }

    .login{
        position: absolute;
        top: 50%;
        left: 50%;
        margin: -150px 0 0 -150px;
        width:300px;
        height:300px;
    }

    article {
        columns: 3;

    }


    .line{
        position: float;
        text-align:center;
    }

    .block{
        display: inline-block;
    }
    </style>
@php
$user = App\Models\User::where('id', Auth::id())->first();
$photo = App\Models\Photo::where('event_id', $event->id)->first();
if($photo != null){
    $image_path = App\Models\Photo::where('event_id', $event->id)->first()->image_path;
} else {
    $image_path = "party.png";
}
@endphp


<div class="gray">
    <div>
        <h1 style=display:inline; class="">{{ $event->title }} </h1>
        <div><img class="right" style="max-height:100px; max-width:100px;" src="{{ asset('assets/eventImages/' .$image_path) }}" alt="Event Picture"></div>
        
        
        @if (!$user->is_banned)
            <h2 class="">{{ $event->description }} </h2>
            
            @if ($role === 'Owner' or $role === 'Moderator' or $role === 'Participant')
                <h3>
                    <label style=display:inline;>Date:</label>
                    {{ $event->start_date }} ({{ $timeLeft }} days until start, duration: {{ $duration }} days)
                </h3>
                <h3><label style="display:inline;">End date:</label> {{ $event->end_date }}</h3>
                <h4 class="">
                    <label style=display:inline;>Location: </label>
                    {{ $event->location }}
                </h4>
            @endif

            <div class="line">
            <article>
            @if ($role === 'Owner' or $role === 'Moderator' or $user->is_admin)
                
            
                @if ($role === 'Owner' or $user->is_admin)
                    <div class="block">
                        <form method="post" action="{{ route('delete_event', ['id' => $event->id]) }}">
                            @csrf
                            @method("DELETE")
                            <input type='hidden' id='id' name='id' value='{{ $event->id }}'>
                            <button type="submit" class="btn btn-primary">
                               Delete event
                            </button>
                        </form>
                    </div>
                @endif
                
            
                
            <div class="block"><a class="btn btn-primary" href="{{ url('event_edit/'. $event['id']) }}"> Edit </a></div>
            
            
            
            <div class="block"><a class="btn btn-primary" href="{{ url('event/'. $event['id'].'/create_poll') }}"> Create poll </a></div>
            
            
            
            <div class="block">
                <form action="{{ url('event/'. $event['id']. '/all_participants') }}">
                    <input type='hidden' id='id' name='id' value='{{ $event->id }}'>
                    <button type="submit" class="btn btn-primary">
                        All participants
                    </button>
                </form>
            </div>

            @endif
            </article>
            </div>



            @if ($role === 'Guest' and !$user->is_banned)
                <a class="btn btn-primary" href="/event/{{ request()->route('id') }}/join"> Join </a>
            @elseif ($role === 'Unconfirmed')
                <a class="btn btn-primary" href="/event/{{ request()->route('id') }}/quit"> Remove request</a>
            @elseif ($role !== 'Owner' and $role !== 'Blocked')
                <a class="btn btn-primary" href="/event/{{ request()->route('id') }}/quit"> Quit </a>
            @endif
            @if ($role === 'Blocked')
                <h2 style="color: rgb(230, 58, 10)"> You was banned by moderator! </h2>
            @endif
        @endif



    </div>
    <p></p>
    <div>
        @if (($role === 'Owner' or $role === 'Moderator' or $role === 'Participant') and !$user->is_banned)
            @each('partials.poll',$event->polls()->get(), 'poll')
            <form method="post" action="{{ route('new_comment', ['id' => $event->id]) }}">
                @csrf
                <label> New comment </label>
                <input style="color:#000" type="text" id="content" name="content"></input>
                <input type="hidden" id="event_id" name="event_id" value="{{$event['id']}}"></input>
                <button type="submit" class="btn btn-primary">Comment</button>
            </form>
            @each('partials.comment',$event->comments()->get(), 'comment')
        @endif
    </div>
</div>
</x-layout>