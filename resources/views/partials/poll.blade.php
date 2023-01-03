<style>
#outer
{
    width:100%;
    text-align: center;
}
.inner
{
    display: inline-block;
}

</style>

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
        <div class="option" id="outer">
            <div class="inner">
            @php
                $number_of_votes = \App\Models\Poll_vote::where('event_id', $poll->event_id)->where('poll_id', $poll->id)->where('choice_id', $option->id)->get()->count();
            @endphp
            </div>
            <div class="inner">
            <h3>{{$option->choice}}</h3>
            </div>
            <div class="inner">
            <button  class="mark">
                <a id="len5" class="hoverable" href="{{ url('/event/'.$poll->event_id.'/vote/'.$poll->id."/".$option->id) }}" style="color: rgb(38, 77, 206);">click</a>
            </button>
            </div>
            <div class="inner">
            <h3>{{$number_of_votes}}</h3>
            </div>
        </div>
    @endforeach
</div>