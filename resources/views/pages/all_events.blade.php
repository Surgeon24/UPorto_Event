@extends('layouts.layout')

@section('event')

  @include('partials.event_list', ['events' => $event])


  
@endsection





