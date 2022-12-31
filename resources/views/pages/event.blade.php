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
</style>

<div class="gray">
    <div >
        <h1 style=display:inline; class="">{{ $event->title }} </h1>

        <h2 class="">{{ $event->description }} </h2>
        @if ($role === 'Owner' or $role === 'Moderator' or $role === 'Participant')
        <h3 class="">
            <label style=display:inline;>Date:</label>
            {{ $event->start_date }}

        </h3>
        <h4 class="">
            <label style=display:inline;>Location: </label>
            {{ $event->location }}
        </h4>
        @endif
        <div>
            <article>
            @if ($role === 'Owner' or $role === 'Moderator')
                <div>
                    <a class="btn btn-primary" href="{{ url('event_edit/'. $event['id']) }}"> Edit </a>
                </div>
                @if ($role === 'Owner')
                    <div>
                    <form method="post" action="{{ route('delete_event', ['id' => $event->id]) }}">
                        @csrf
                        @method("DELETE")
                        <input type='hidden' id='id' name='id' value='{{ $event->id }}'>
                        <button type="submit" class="btn btn-primary">
                            Delete
                        </button>
                    </form>
                    </div>
                @endif
                <div>
                    <div>
                        {{ $event->id }}
                        <form action="{{ url('event/'. $event['id']. '/all_participants') }}">
                            <input type='hidden' id='id' name='id' value='{{ $event->id }}'>
                            <button type="submit" class="btn btn-primary">
                                All participants
                            </button>
                        </form>
                    </div>
                </div>
            @endif
            </article>
            @if ($role === 'Guest')
                <a class="btn btn-primary" href="/event/{{ request()->route('id') }}/join"> Join </a>
            @elseif ($role === 'Unconfirmed')
            <a class="btn btn-primary" href="/event/{{ request()->route('id') }}/quit"> Remove request</a>
            @elseif ($role !== 'Owner')
                <a class="btn btn-primary" href="/event/{{ request()->route('id') }}/quit"> Quit </a>
            @endif
        </div>
    </div>
</div>
<div class="gray">
    @if ($role === 'Owner' or $role === 'Moderator' or $role === 'Participant')
        <form method="post" action="{{ route('new_comment', ['id' => $event->id]) }}">
            @csrf
            <label> New comment </label>
            <input style="color:#000" type="text" id="content" name="content"></input>
            <input type="hidden" id="event_id" name="event_id" value="{{$event['id']}}"></input>
            <button type="submit" class="btn btn-primary">Comment</button>
        </form>
    @endif

</div>
@each('partials.comment',$event->comments()->get(), 'comment')


</div>
</div>
</x-layout>