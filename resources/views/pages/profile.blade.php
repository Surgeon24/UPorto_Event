@extends('layouts.app')

@section('profile')
  <div >
        <div>
          
          <div>
          <img class="media-object"
                                     src="{{ asset('assets/profileImages/'.$user->photo_path) }}"
                                     alt="Profile Picture">
          </div>
          
            <h2 class="">{{ $user->name }} </h2>
            <h3 class="">{{ $user->email }} </h3>
        </div>

        @if ($user['id'] === Auth::id())
          <a class="button" href="{{ url('profile_edit/'. $user['id']) }}" > Edit </a>  
          <a class="button" href="{{ url('event_create/') }}" > + Event </a>
          <form action="{{ route('delete_user', ['id' => $user->id]) }}"  method="post">
            @csrf
            @method("DELETE")
            <button type="submit">
              Delete
            </button>
          </form>      
        @endif    
  </div> 
@endsection


