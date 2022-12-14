@extends('layouts.app')

@section('content')
    @include('partials._search')
    @include('partials.event_list', ['events' => $event])
@endsection