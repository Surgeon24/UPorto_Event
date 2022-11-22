@extends('layouts.app')

@section('profile')
  <div >
        <div>
          
          <div>
          <img class="" src="{{ asset($user->getPhotoPath()) }}"
                                     alt="Profile Picture">
          </div>
          
            <h2 class="">{{ $user->name }} </h2>
            <h3 class="">{{ $user->email }} </h3>
        </div>
        
        <a class="button" href="{{ url('profile_edit/'. $user['id']) }}" > Edit </a>      
  </div> 
@endsection


