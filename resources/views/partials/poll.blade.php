@php
    $options= \App\Models\Poll_choice::where('poll_id', $poll->id)->get();
@endphp

<p></p>
<div>
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