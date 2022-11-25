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
        
        <a class="button" href="{{ url('profile_edit/'. $user['id']) }}" > Edit </a>  
        <a class="button" href="{{ url('event_create/') }}" > + Event </a>          
  </div> 
@endsection


