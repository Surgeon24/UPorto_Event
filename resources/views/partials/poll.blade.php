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
        box-sizing: border-box;
        transition: 0.3s;
        border-radius: 5px;
        /* 5px rounded corners */
        border-style: solid;
        border-width: medium;
    }

    /* Add rounded corners to the top left and the top right corner of the image */
    img {
        border-radius: 5px 5px 0 0;
    }

    @keyframes anim {
        100% {
            transform: rotate(-15deg) scale(1.3);
            -webkit-transform: rotate(-15deg) scale(1.3);
            -moz-transform: rotate(-15deg) scale(1.3);
            -ms-transform: rotate(-15deg) scale(1.3);
            -o-transform: rotate(-15deg) scale(1.3);
            filter: blur(0.5px);
            -webkit-filter: blur(0.5px);
        }
    }




    .g{
    padding: 50px;
    text-align: center;
    background-color: rgba(0, 0, 0, 0.6);
    color: white;
    height: 300px;
  }

    * {
      box-sizing: border-box;
    }
</style>


@php
    $options= \App\Models\Poll_choice::where('poll_id', $poll->id)->get();
@endphp

<p></p>
<div class="g">
    <div class="poll_head">
        <p>
            <span class="hl-scrolled-to-wrap">
            <div><h2>{{$poll->question}}</h2></div>
            </span>
        </p>
        <div class="clear"></div>
    </div>
    @foreach ($options as $option)
        <div class="option">
            @php
                $number_of_votes = \App\Models\Poll_vote::where('event_id', $poll->event_id)->where('poll_id', $poll->id)->where('choice_id', $option->id)->get()->count();
            @endphp
            <h3>{{$number_of_votes}}</h3>
            <button  class="mark">
                <a id="len5" class="hoverable" href="{{ url('/event/'.$poll->event_id.'/vote/'.$poll->id."/".$option->id) }}" style="color: rgb(38, 77, 206);">click</a>
            </button>
           <h3>{{$option->choice}}</h3>
        </div>
    @endforeach
</div>