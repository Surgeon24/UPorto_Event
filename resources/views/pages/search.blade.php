@extends('layouts.layout')

@section('content')
    @include('partials.event_list', ['events' => $event])
@endsection