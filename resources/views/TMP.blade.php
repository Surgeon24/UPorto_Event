@extends('layouts.app')

@section('content')
<a class="button" href="{{ url('/profile/'. Auth::user()->id) }}"> {{ Auth::user()->name }} </a>

@endsection