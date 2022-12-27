@extends('layouts.layout')

@section('event')
  @include('partials._search')
  @include('partials.event_list', ['events' => $event])


  
@endsection





