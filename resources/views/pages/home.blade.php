@extends('layouts.layout')

@section('content')




    <section class="u-clearfix u-section-1" id="home section">
      <div class="u-clearfix u-sheet u-sheet-1">
        <h2 class="u-text u-text-default u-text-1">Welcome to the UPorto Event</h2>

        <h4 class="u-text u-text-default u-text-2"> It's never to late to do LBAW!</h4>
        <a class="button" href="{{ url('/all_events') }}"> Show all events </a>

       <!--  @include('partials._search') -->
       <link href="{{ asset('css/search.css') }}" rel="stylesheet">

        <div class="container">
          <input type="text" placeholder="Search...">
          <div class="search"></div>
        </div>
      
      </div>
    
    
@endsection
