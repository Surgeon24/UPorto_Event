@extends('layouts.layout')
@section('content')

<style>



  .gray{
     position: relative;
     padding: 50px;
     text-align: center;
     background-color: rgba(0, 0, 0, 0.8);
     color: white;       
   }
</style>

<h1>All events</h1>

@include ('partials._search');

<div >
  <div style="display:flex; gap:10px;">
    @foreach($events as $event)
    <article class="gray">
      <a href="{{ route('event', ['id' => $event->id]) }}">
        <h1 class="">{{ $event->title }}
          <h1>
            <h2 class="">{{ $event->description }} </h2>
            <h3 class="">
              <label style=display:inline;>Date:</label>
              {{ $event->start_date }}

            </h3>
            <h4 class="">
              <label style=display:inline;>Location: </label>
              {{ $event->location }}
            </h4>
      </a>
    </article>
    @endforeach
  </div>
</div>

@endsection