@extends('layouts.app')

@section('profile')
  <div >
        <div>
            <h1> <?= $user->name ?> </h1>
            <h2> <?= $user->email ?> </h2>
        </div>
        
        <a class="button" href="{{ url('profile_edit/'. $user['id']) }}" > Edit </a>      
  </div> 
@endsection


