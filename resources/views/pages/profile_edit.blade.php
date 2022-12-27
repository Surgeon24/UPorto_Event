@extends('layouts.layout')

@section('content')
<div>
  <form method="post" action="{{ route('user-update', ['id' => $user->id]) }}" accept-charset="UTF-8">
    {{ csrf_field() }}
    <div>
      <label for="name">Username</label>
      <input type="text" id="name" name="name" value="{{$user['name']}}">
      </input>
    </div>
    <div>
      <label for="email">Email</label>
      <input type="text" id="email" name="email" value="{{$user['email']}}">
      </input>
    </div>


    <button type="submit">submit</button>
  </form>
</div>
@endsection