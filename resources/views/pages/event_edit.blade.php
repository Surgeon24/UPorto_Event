@extends('layouts.layout')

@section('content')
<div class="gray">
  <form method="post" action="{{ route('event_update', ['id' => $event->id]) }}" accept-charset="UTF-8">
    {{ csrf_field() }}
    <div>
      <label for="title">Title</label>
      <input type="text" STYLE="color: #333333; background-color: #DDDDDD;" id="title" name="title" value="{{$event['title']}}"> </input>
    </div>
    <button type="submit" class="btn btn-primary">submit</button>
  </form>
</div>
@endsection