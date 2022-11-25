@extends('layouts.app')

@section('event_edit')
<div>
  <form method="post" action="{{ route('event_edit', ['id' => $event->id]) }}" accept-charset="UTF-8">
    {{ csrf_field() }}
    <div>
      <label for="title">Title</label>
      <input type="text" id="title" name="title" value="{{$event['title']}}">
      </input>
    </div>
    <button type="submit">submit</button>
  </form>
</div>
@endsection