@extends('layouts.app')

@section('event')
  @include('partials.event_list', ['events' => $event])
@endsection